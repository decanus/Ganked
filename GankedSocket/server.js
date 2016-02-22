/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const config = require('./lib/configuration')(),
      http = require('http'),
      ws = require('ws'),
      handleConnection = require('./lib/handlers/handle-connection'),
      handleRequest = require('./lib/handlers/handle-request'),
      pingLoop = require('./lib/socket/ping-loop'),
      wrapHandler = require('./lib/http/wrap-handler');

let server = http.createServer(),
    wsServer = new ws.Server({ server: server }),
    sessions = new Map();

server.on('request', wrapHandler(handleRequest, sessions));
wsServer.on('connection', socket => handleConnection(socket, sessions));

pingLoop(wsServer, 1000);

server.listen(config.port, () => {
    console.log('Listening on ' + server.address().port);
});