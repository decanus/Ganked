/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const getPostData = require('../http/get-post-data'),
      BadRequest = require('../http/bad-request');

/**
 *
 * @param {{}} params
 */
function validateData(params) {
    if (!params.hasOwnProperty('userId')) {
        return 'userId is required';
    }
}

/**
 *
 * @param {{userId: string}} data
 * @param {Map} sessions
 */
function pushNotification(data, sessions) {
    let userId = data.userId;

    if (!sessions.has(userId)) {
        return false;
    }

    sessions.get(userId).forEach(target => target.sendEvent('notification', {}));

    return true;
}

/**
 *
 * @param {Request} request
 * @param {Map} sessions
 * @returns {Promise}
 */
function notifications(request, sessions) {
    return getPostData(request.request).then(params => {
        let error = validateData(params);

        if (error) {
            return Promise.reject(new BadRequest(error));
        }

        return { data: { status: pushNotification(params, sessions) }, headers: {} };
    });
}

module.exports = notifications;