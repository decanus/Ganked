/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

/**
 *
 * @param {Request} request
 * @returns {Promise}
 */
function notFound(request) {
    return Promise.reject({ status: 404, message: 'resource not found' });
}

module.exports = notFound;