/**
 * (c) 2015 Ganked <ganked.net>
 */

import { matches } from './matches';

/**
 *
 * @param {HTMLElement} element
 * @param {string} selector
 * @returns {Node}
 */
export function findClosestParent(element, selector) {
    let parent = element.parentNode;

    if (parent === null || parent === element.ownerDocument) {
        return null;
    }

    if (matches(parent, selector)) {
        return parent;
    }

    return findClosestParent(parent, selector);
}