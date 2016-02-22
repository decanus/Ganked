/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

/**
 *
 * @param {Element} $
 * @return {number}
 */
export function getAutoHeight($) {
    let height, originalHeight = $.style.height;

    $.style.height = 'auto';
    height = $.getBoundingClientRect().height;
    $.style.height = originalHeight;

    return height;
}