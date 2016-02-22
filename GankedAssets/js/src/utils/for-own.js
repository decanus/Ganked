/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {Object} object
 * @param {Function} callback
 * @param {Object} [thisArg]
 */
export function forOwn(object, callback, thisArg) {
    Object.getOwnPropertyNames(object).forEach(function (key) {
        callback.call(thisArg, object[key], key);
    });
}