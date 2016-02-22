/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

/**
 *
 * @param {Map} sessions
 * @param {Client} socket
 */
function addSocket(sessions, socket) {
    let userId = socket.userId,
        clients = sessions.get(userId);

    if (!sessions.has(userId)) {
        clients = new Set();
        sessions.set(userId, clients);
    }

    clients.add(socket);
}

module.exports = addSocket;