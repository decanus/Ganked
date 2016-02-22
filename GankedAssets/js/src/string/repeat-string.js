/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {string} string
 * @param {number} times
 */
export function repeatString(string, times) {
    return Array.from({ length: times }).map(() => string).join('');
}