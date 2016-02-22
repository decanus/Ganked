/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { forOwn } from '../../utils/for-own';

/**
 *
 * @param {Object} storage
 * @returns {string}
 */
export function stringifyQuery(storage) {
    let parts = [];

    forOwn(storage, function (value, key) {
        parts.push([key, value].map(encodeURIComponent).join('='));
    });

    return parts.join('&');
}