/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

/**
 *
 * @param {Element} $
 * @param {string} property
 * @returns {boolean}
 */
export function propertyHasTransition($, property) {
    let style = getComputedStyle($),
        props = style['transition-property'].split(',').map(s => s.trim());


    return props.indexOf(property) !== -1;
}