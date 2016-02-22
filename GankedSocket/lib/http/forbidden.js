/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const util = require('util');

/**
 *
 * @param {string} message
 */
function Forbidden(message) {
    /**
     *
     * @type {number}
     */
    this.status = 403;

    /**
     *
     * @type {string}
     */
    this.message = message;
}

util.inherits(Forbidden, Error);

module.exports = Forbidden;