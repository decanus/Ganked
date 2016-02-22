/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

/**
 *
 * @param {Map} sessions
 * @param {Client} socket
 */
function removeSocket(sessions, socket) {
    let userId = socket.userId, clients;

    if (!sessions.has(userId)) {
        return;
    }

    clients = sessions.get(userId);
    clients.delete(socket);

    if (clients.size === 0) {
        sessions.delete(userId);
    }
}

module.exports = removeSocket;