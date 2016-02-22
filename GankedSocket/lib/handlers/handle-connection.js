/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const handleSession = require('./handle-session'),
      Client = require('../socket/client');

/**
 *
 * @param {Client} socket
 * @param {Map} sessions
 */
function handleConnection(socket, sessions) {
    let client = new Client(socket);

    if (client.path[0] === 'session') {
        return handleSession(client, sessions);
    }

    client.close('authentication failed');
}

module.exports = handleConnection;