/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

import { CoreElement } from './core';

class TimelineValue extends CoreElement {
    /**
     * @internal
     */
    render() {
        this.textContent = this.value;
    }

    /**
     *
     * @returns {string}
     */
    get key() {
        return this.getAttribute('key');
    }

    /**
     *
     * @returns {string}
     */
    get player() {
        return this.getAttribute('player');
    }

    /**
     *
     * @param {string} value
     */
    set value(value) {
        this.setAttribute('value', value);
        this.render();
    }

    /**
     *
     * @returns {string}
     */
    get value() {
        return this.getAttribute('value');
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function timelineValue(document) {
    document.registerElement('timeline-value', TimelineValue);
}