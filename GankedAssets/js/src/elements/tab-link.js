/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { CoreElement } from './core';
import { forEach } from '../utils/for-each';

class TabLink {
    /**
     * @internal
     */
    attachedCallback() {
        this.addEventListener('click', e => {
            e.preventDefault();

            let $tab = this.ownerDocument.querySelector(this.href);
            $tab.show();

            forEach($tab.$tabs, $tab => {
                forEach($tab.$links, $link => {
                    $link.classList.remove('-active');
                });
            });

            this.classList.add('-active');
        });
    }

    /**
     *
     * @returns {string}
     */
    get href() {
        return this.getAttribute('href');
    }
}

Object.setPrototypeOf(TabLink.prototype, HTMLLinkElement.prototype);

/**
 *
 * @param {HTMLElement} document
 */
export default function (document) {
    document.registerElement('tab-link', {
        prototype: TabLink.prototype,
        'extends': 'a'
    });
}