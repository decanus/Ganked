/**
 * (c) 2015 Ganked
 */

import { Promise } from 'es6-promise';

/**
 *
 * @param {string} url
 * @returns {Promise<Worker>}
 */
export function getWorker(url) {
    return fetch(url)
        .then(resp => resp.blob())
        .then(blob => new Worker(URL.createObjectURL(blob)));
}