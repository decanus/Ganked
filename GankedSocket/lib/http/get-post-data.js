/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const querystring = require('querystring'),
      getRequestBody = require('./get-request-body');

/**
 *
 * @param {http.IncomingMessage} request
 * @returns {Promise<{}>}
 */
function getPostData(request) {
    return getRequestBody(request).then(data => querystring.parse(data));
}

module.exports = getPostData;