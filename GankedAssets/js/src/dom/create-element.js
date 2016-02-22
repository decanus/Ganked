/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

import { forOwn } from '../utils/for-own';
import Symbol from 'es6-symbol';

/**
 *
 * @type {Symbol}
 */
export const text = Symbol('text');

/**
 *
 * @param {Document} document
 * @param {string} tagName
 * @param {{}} [options]
 * @returns {Element}
 */
export function createElement(document, tagName, options = {}) {
    let $elem = document.createElement(tagName);

    forOwn(options, (value, name) => {
        if (name !== text.toString()) {
            $elem.setAttribute(name, value);
        }
    });

    if (options[text] !== undefined) {
        $elem.textContent = options[text];
    }

    return $elem;
}