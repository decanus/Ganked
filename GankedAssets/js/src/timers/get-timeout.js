/**
 * (c) 2015 Ruben Schmidmeister
 */

import { Promise } from 'es6-promise';

/**
 *
 * @param {number} [timeout]
 */
export function getTimeout(timeout) {
    return new Promise(resolve => {
        window.setTimeout(() => resolve(), timeout);
    });
}