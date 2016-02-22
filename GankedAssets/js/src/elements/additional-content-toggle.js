/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { CoreElement } from './core';
import { setBooleanAttribute } from '../dom/set-boolean-attribute';
import { getDocumentOf } from '../dom/document/get-document-of';

class AdditionalContentToggle extends CoreElement {
    /**
     * @internal
     */
    attachedCallback() {
        this.addEventListener('click', () => {
            let $target = this.$target;

            if (!$target) {
                console.warn(`could not find target ${this.target}`, this);
                return;
            }

            Promise.all($target.map($ => $.toggle())).then($ => {
                let attr = 'show-more';

                if ($[0].visible) {
                    attr = 'show-less';
                }

                this.innerText = this.getAttribute(attr);
            });
        });
    }

    /**
     *
     * @returns {string}
     */
    get target() {
        return this.getAttribute('target-name');
    }

    /**
     *
     * @returns {Array<Element>}
     */
    get $target() {
        //noinspection JSCheckFunctionSignatures
        return Array.from(getDocumentOf(this).querySelectorAll(`additional-content[name="${this.target}"]`));
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function additionalContentToggle(document) {
    document.registerElement('additional-content-toggle-button', {
        extends: 'button',
        prototype: Object.create(AdditionalContentToggle.prototype)
    });

    document.registerElement('additional-content-toggle-link', {
        extends: 'a',
        prototype: Object.create(AdditionalContentToggle.prototype)
    });
}
