/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {HTMLDocument} [document]
 * @returns {number}
 */
export function getScrollTop(document = window.document) {
    return document.body.scrollTop || document.documentElement.scrollTop;
}