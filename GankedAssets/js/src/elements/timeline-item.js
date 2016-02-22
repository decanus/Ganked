/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

import { CoreElement } from './core';
import { setBooleanAttribute } from '../dom/set-boolean-attribute';
import { document } from '../dom/document/document';
import { createElement, text } from '../dom/create-element';
import { scan } from '../elements/info-box';

class TimelineItem extends CoreElement {
    /**
     * @internal
     */
    render() {
        let doc = document(this);

        this.empty();

        this.appendChild(createElement(doc, 'img', {
            src: this.src,
            'data-info-box': 'info-box'
        }));
    }

    /**
     *
     * @returns {string}
     */
    get src() {
        return this.getAttribute('src');
    }

    /**
     *
     * @param {string} value
     */
    set src(value) {
        this.setAttribute('src', value);
    }

    /**
     *
     * @returns {string}
     */
    get title() {
        return this.getAttribute('title');
    }

    /**
     *
     * @param {string} value
     */
    set title(value) {
        this.setAttribute('title', value);
    }

    /**
     *
     * @returns {string}
     */
    get description() {
        return this.getAttribute('description');
    }

    /**
     *
     * @param {string} value
     */
    set description(value) {
        this.setAttribute('description', value);
    }

    /**
     *
     * @returns {number}
     */
    get player() {
        return Number(this.getAttribute('player'));
    }

    /**
     *
     * @param {number} number
     */
    set player(number) {
        this.setAttribute('player', number);
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function timelineItem(document) {
    document.registerElement('timeline-item', TimelineItem);
}