/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

/**
 *
 * @param {WebSocketServer} server
 * @param {number} interval
 * @return {number}
 */
function pingLoop(server, interval) {
    let loop = () => {
        server.clients.forEach(client => client.ping('ping', {}, true));
    };

    return setInterval(loop, interval);
}

module.exports = pingLoop;