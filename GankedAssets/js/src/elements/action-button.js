/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { CoreElement } from './core';
import { forEach } from '../utils/for-each';
import { findClosestParent } from '../dom/find-closest-parent';

export class ActionButton {
    /**
     * @internal
     */
    attachedCallback() {
        let $form = findClosestParent(this, 'form[is=ajax-form]');

        if ($form === null) {
            return console.warn('action-button outside from', this);
        }

        this.addEventListener('click', () => {
            let rect = this.getBoundingClientRect();

            this.style.width = `${rect.width}px`;
            this.style.height = `${rect.height}px`;

            this.classList.add('-loading');
        });

        $form.addEventListener('error', () => this.normalize());
        $form.addEventListener('response', () => {
            this.active = !this.active;

            this.normalize();

            $form.action = this.action;

            if (this.hasAttribute('disable-active')) {
                this.setAttribute('disabled', '');
            }
        });
    }

    normalize() {
        this.style.width = '';
        this.style.height = '';

        this.classList.remove('-loading');
    }

    /**
     *
     * @returns {string}
     */
    get text() {
        return this.getAttribute(this.active ? 'active-text' : 'text');
    }

    /**
     *
     * @returns {Element}
     */
    get $text() {
        return this.querySelector(':scope > .text');
    }

    /**
     *
     * @returns {string}
     */
    get action() {
        return this.getAttribute(this.active ? 'active-action' : 'action');
    }

    /**
     *
     * @returns {boolean}
     */
    get active() {
        return this.classList.contains('-active');
    }

    /**
     *
     * @param {boolean} value
     * @returns {void}
     */
    set active(value) {
        if (value) {
            this.classList.add('-active');
        } else {
            this.classList.remove('-active');
        }

        this.$text.innerText = this.text;
    }
}

Object.setPrototypeOf(ActionButton.prototype, HTMLButtonElement.prototype);

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('action-button', {
        prototype: ActionButton.prototype,
        'extends': 'button'
    });
}