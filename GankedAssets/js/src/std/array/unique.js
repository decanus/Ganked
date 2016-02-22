/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 * Returns a new array with unique entries only.
 *
 * @param {Array} array
 * @returns {Array}
 */
export function unique(array) {
    return array.filter((value, idx) => array.indexOf(value) === idx);
}