/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { CoreElement } from './core';
import { forEach } from '../utils/for-each';
import { document } from '../dom/document/document';

class GnkdTab extends CoreElement {
    /**
     * @internal
     */
    createdCallback() {
        if (this.group === '') {
            console.warn('tab with empty group', this);
        }
    }

    /**
     * @api
     */
    show() {
        forEach(this.$tabs, $tab => $tab.hide());
        Array.from(this.querySelectorAll('[gnkd-render]'))
            .filter($ => $.render instanceof Function)
            .map($ => $.render());

        this.hidden = false;
    }

    /**
     * @api
     */
    hide() {
        this.hidden = true;
    }

    /**
     *
     * @returns {string}
     */
    get group() {
        return this.getAttribute('group') || '';
    }

    /**
     *
     * @param {string} value
     */
    set group(value) {
        this.setAttribute('group', value);
    }

    /**
     * @returns {NodeList}
     */
    get $tabs() {
        return document(this).querySelectorAll(`gnkd-tab[group="${this.group}"]`);
    }

    /**
     *
     * @returns {NodeList}
     */
    get $links() {
        return document(this).querySelectorAll(`a[href="#${this.id}"]`);
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function(document){
    document.registerElement('gnkd-tab', GnkdTab);
}