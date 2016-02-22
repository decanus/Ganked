/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { Promise } from 'es6-promise';

export class Provider {
    /**
     *
     * @param {string} query
     * @returns {Promise}
     */
    search(query) {
        return new Promise((done) => {
            this.doSearch(query, (items) => {
                done({ query, items });
            });
        });
    }

    /**
     *
     * @param {string} query
     * @param {Function} done
     */
    doSearch(query, done) {
        done(new Set());
    }
}