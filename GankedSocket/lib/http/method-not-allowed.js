/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const util = require('util');

/**
 *
 * @param {string} method
 */
function MethodNotAllowed(method) {
    /**
     *
     * @type {number}
     */
    this.status = 405;

    /**
     *
     * @type {string}
     */
    this.message = `method '${method}' is not allowed`;
}

util.inherits(MethodNotAllowed, Error);

module.exports = MethodNotAllowed;