/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {HTMLElement} $
 * @param {string} attr
 * @param {*} [defaultValue]
 * @returns {*}
 */
export function getJSONAttribute($, attr, defaultValue) {
    if (!$.hasAttribute(attr)) {
        return defaultValue;
    }

    try {
        return JSON.parse($.getAttribute(attr));
    } catch(_) {
        return defaultValue;
    }
}