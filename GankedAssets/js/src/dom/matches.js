/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {Element} $
 * @param {string} selector
 */
export function matches($, selector) {
    switch ('function') {
        case (typeof $.matches):
            return $.matches(selector);
        case (typeof $.webkitMatchesSelector):
            return $.webkitMatchesSelector(selector);
        case (typeof $.msMatchesSelector):
            return $.msMatchesSelector(selector);
    }

    throw new Error('matches() is not supported by this browser');
}
