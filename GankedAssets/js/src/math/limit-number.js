/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {number} number
 * @param {number} min
 * @param {number} max
 *
 * @returns {number}
 */
export function limitNumber(number, min = -Infinity, max = Infinity) {
    if (number < min) {
        return min;
    }

    if (number > max) {
        return max;
    }

    return number;
}