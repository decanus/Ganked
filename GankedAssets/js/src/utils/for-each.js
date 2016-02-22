/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {{length: number}} list
 * @param {Function} callbackFn
 * @param {Object} [thisArg]
 */
export function forEach(list, callbackFn, thisArg) {
    return [].forEach.call(list, callbackFn, thisArg);
}