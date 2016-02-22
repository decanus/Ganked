/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const util = require('util');

/**
 *
 * @param {string} message
 */
function BadRequest(message) {
    /**
     *
     * @type {number}
     */
    this.status = 400;

    /**
     *
     * @type {string}
     */
    this.message = message;
}

util.inherits(BadRequest, Error);

module.exports = BadRequest;