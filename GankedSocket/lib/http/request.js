/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

/**
 *
 * @param {http.IncomingMessage} request
 * @param {string} url
 * @param {string} method
 */
function Request(request, url, method) {
    /**
     *
     * @type {http.IncomingMessage}
     */
    this.request = request;

    /**
     *
     * @type {string}
     */
    this.url = url;

    /**
     *
     * @type {string}
     */
    this.method = method;

    Object.freeze(this);
}

Object.defineProperty(Request.prototype, 'path', {
    get() {
        return this.url.pathname;
    }
});

Object.defineProperty(Request.prototype, 'query', {
    get() {
        return this.url.query;
    }
});

module.exports = Request;