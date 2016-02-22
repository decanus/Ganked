/**
 * (c) 2015 Ganked
 */

import { getLocalStorage } from '../std/storage/wrapper';
import { removeAllSummoners, getSummoners } from '../lol/comparison';
import { document } from '../dom/document/document';
import { setBooleanAttribute } from '../dom/set-boolean-attribute';

/**
 *
 * @type {StorageWrapper}
 */
const localStorage = getLocalStorage();

class CompareClearButton {
    attachedCallback() {
        this.addEventListener('click', () => {
            removeAllSummoners(localStorage);
            document(this).dispatchEvent(new CustomEvent('lolComparisonUpdate'));
        });

        document(this).addEventListener('lolComparisonUpdate', () => this.render());
        this.render();
    }

    render() {
        /**
         *
         * @type {boolean}
         */
        this.hidden = (getSummoners(localStorage).length === 0);
    }

    /**
     *
     * @param {boolean} hidden
     */
    set hidden(hidden) {
        setBooleanAttribute(this, 'hidden', hidden);
    }

    /**
     *
     * @returns {boolean}
     */
    get hidden() {
        return this.hasAttribute('hidden');
    }
}

Object.setPrototypeOf(CompareClearButton.prototype, HTMLButtonElement.prototype);

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('compare-clear-button', {
        prototype: CompareClearButton.prototype,
        'extends': 'button'
    });
}