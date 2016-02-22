/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { forEach } from '../utils/for-each';
import { CoreElement } from './core';
import { parseFragment } from '../dom/parse-fragment';
import { isDescendant } from '../dom/is-descendant';

import Symbol from 'es6-symbol';

/**
 * @type {symbol}
 */
const listener = Symbol('listener');

class ModalDialog extends CoreElement {
    /**
     * @internal
     */
    createdCallback() {
        let close = this.$closeButton;

        if (close !== null) {
            close.addEventListener('click', () => this.hide());
        }

        this.addEventListener('click', (e) => {
            if (!isDescendant(this.$inner, e.target)) {
                this.hide();
            }
        });
    }

    /**
     * @internal
     */
    attachedCallback() {
        this[listener] = document.addEventListener('keyup', (e) => {
            if (e.keyCode === 27) {
                this.hide();
            }
        });
    }

    /**
     * @internal
     */
    detachedCallback() {
        this.hide();
        document.removeEventListener(this[listener]);
    }

    /**
     * @api
     */
    hide() {
        this.hidden = true;
        this.dispatchEvent(new CustomEvent('hide'));
    }

    /**
     * @api
     */
    show() {
        this.hidden = false;
        this.dispatchEvent(new CustomEvent('show'));

        // Focus close button
        let close = this.$closeButton;

        if (close !== null) {
            close.focus();
        }

        // force lazy content to fetch
        forEach(this.querySelectorAll('fetch-content[status=lazy]'), $ => $.fetch());
    }

    /**
     *
     * @returns {HTMLElement}
     */
    get $closeButton() {
        return this.querySelector('[data-role="modal:close"]');
    }

    /**
     *
     * @returns {Element}
     */
    get $inner() {
        return this.querySelector(':scope > .inner');
    }
}


export default function () {
    document.registerElement('modal-dialog', ModalDialog);

    let $links = document.querySelectorAll('a[target="modal-dialog"]');

    forEach($links, function ($link) {
        $link.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).show();

            return false;
        });
    });

    let $targets = document.querySelectorAll('[data-modal-dialog]');

    forEach($targets, $ => {
        $.addEventListener('click', (e) => {
            e.preventDefault();

            document.querySelector($.dataset.modalDialog).show();
        });
    });
}
