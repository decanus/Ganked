/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const addSocket = require('../session/add-socket'),
      removeSocket = require('../session/remove-socket'),
      getUserFromSession = require('../query/get-user-from-session');

/**
 *
 * @param {string} origin
 * @returns {boolean}
 */
function isValidOrigin(origin) {
    return origin === 'https://dev.ganked.net' || origin === 'https://www.ganked.net';
}

/**
 *
 * @param {Client} socket
 * @param {Map} sessions
 */
function handleSession(socket, sessions) {
    let sessionId = socket.getCookies().SID,
        origin = socket.origin;

    if (!isValidOrigin(origin)) {
        return socket.close(`origin '${origin}' is not whitelisted`);
    }

    getUserFromSession(sessionId, origin).then(userId => {
        if (!userId) {
            return socket.close('user not logged in');
        }

        socket.userId = userId;

        addSocket(sessions, socket);
        socket.on('close', () => removeSocket(sessions, socket));
    });
}

module.exports = handleSession;