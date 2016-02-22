/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { parseFragment } from '../dom/parse-fragment';
import { insertFirstChild } from '../dom/insert-first-child';
import { removeNode } from '../dom/remove-node';
import { findClosestParent } from '../dom/find-closest-parent';
import { forEach } from '../utils/for-each';
import { forOwn } from '../utils/for-own';

/**
 *
 * @type {Set}
 */
const reservedDataKeys = new Set(['text', 'token']);

class AjaxForm {
    createdCallback() {
        this.addEventListener('submit', e => this._handleSubmit(e));
    }

    /**
     *
     * @param {Event} e
     * @private
     */
    _handleSubmit(e) {
        e.preventDefault();

        fetch(this.action, {
            method: this.method,
            body: new FormData(this),
            credentials: 'include'
        }).then(function (resp) {
            return resp.json();
        }).then((json) => {
            this._removeMessages();

            if (json.status === 'success') {
                return this._handleSuccess(json);
            }

            this._handleError(json);
        });
    }

    /**
     *
     * @private
     */
    _removeMessages() {
        var $formStatus = this.querySelector('.form-status'),
            $labels = this.querySelectorAll('.input-wrap > .message');

        if ($formStatus) {
            removeNode($formStatus);
        }

        forEach($labels, removeNode);
    }

    /**
     *
     * @param {{data: { redirect: string, text: string }}} response
     * @private
     */
    _handleSuccess(response) {
        let data = response.data;

        this.dispatchEvent(new CustomEvent('response', { detail: response }));

        if (data.hasOwnProperty('redirect')) {
            return window.location.replace(data.redirect);
        }

        if (data.hasOwnProperty('text')) {
            insertFirstChild(parseFragment(`<div class="form-status -success">${data.text}</div>`), this);
        }

        if (this.onSuccess.indexOf('remove-inputs') !== -1) {
            Array.from(this.querySelectorAll('input'))
                .forEach($ => $.setAttribute('disabled', ''));
        }
    }

    /**
     *
     * @param {{error: string, data: {}}} response
     */
    _handleError(response) {
        let data = response.data || {};

        this.dispatchEvent(new CustomEvent('error', { detail: response }));

        if (response.hasOwnProperty('error')) {
            insertFirstChild(parseFragment(`<div class="form-status -error">${response.error}</div>`), this);
        }

        forOwn(data, (error, key) => {
            if (reservedDataKeys.has(key)) {
                return;
            }

            let $wrap = findClosestParent(this.querySelector('input[name=' + key + ']'), '.input-wrap');

            $wrap.appendChild(parseFragment(`<div class="message">${error.text}</div>`));
            $wrap.classList.add('-error');
        });
    }

    /**
     *
     * @returns {Array}
     */
    get onSuccess() {
        return (this.getAttribute('on-success') || '').split(/[\s]+/);
    }
}

Object.setPrototypeOf(AjaxForm.prototype, HTMLFormElement.prototype);

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('ajax-form', {
        prototype: AjaxForm.prototype,
        'extends': 'form'
    });
}