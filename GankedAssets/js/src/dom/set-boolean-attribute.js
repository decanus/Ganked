/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {HTMLElement} $
 * @param {string} attr
 * @param {boolean} value
 * @returns {void}
 */
export function setBooleanAttribute($, attr, value) {
    if (value) {
        return $.setAttribute(attr, '');
    }

    $.removeAttribute(attr);
}