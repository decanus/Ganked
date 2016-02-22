/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const MethodNotAllowed = require('../http/method-not-allowed'),
      Forbidden = require('../http/forbidden'),
      url = require('url'),
      tokens = require('../../data/tokens.json'),
      Request = require('../http/request'),
      route = require('../route');

/**
 *
 * @param {http.IncomingMessage} req
 * @returns {Request}
 */
function buildRequest(req) {
    return new Request(
        req,
        url.parse(req.url, true),
        req.method
    );
}

/**
 *
 * @param {http.IncomingMessage} req
 * @param {Map} sessions
 */
function handleRequest(req, sessions) {
    let request = buildRequest(req);

    if (request.method !== 'POST') {
        return Promise.reject(new MethodNotAllowed(request.method));
    }

    if(!tokens.hasOwnProperty(request.query.token)) {
        return Promise.reject(new Forbidden('invalid access token'));
    }

    return route(request.path)(request, sessions);
}

module.exports = handleRequest;