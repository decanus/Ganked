/**
 * (c) 2015 Ganked <ganked.net>
 */

import { Promise } from 'es6-promise';

/**
 *
 * @param {Document} [document]
 * @return {Promise}
 */
export function onReady(document = window.document) {
    if (document.readyState === 'complete') {
        return Promise.resolve(document);
    }

    return new Promise((resolve) => {
        document.addEventListener('DOMContentLoaded', () => {
            resolve(document);
        });
    });
}