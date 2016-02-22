/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {number} start
 * @param {number} end
 * @returns {number}
 */
export function getRandomNumber(start, end) {
    return Math.floor(Math.random() * end) + start;
}