/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 * Use this function only if necessary. Use createElement instead.
 *
 * @see createElement
 * @param {String} string
 * @returns {Node}
 */
export function parseFragment(string) {
    var div = document.createElement('div');
    div.innerHTML = string;

    return div.firstChild;
}