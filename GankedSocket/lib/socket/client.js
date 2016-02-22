/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const cookie = require('cookie');

/**
 *
 * @param {WebSocket} socket
 */
function Client(socket) {
    /**
     *
     * @type {WebSocket}
     */
    this.socket = socket;

    /**
     *
     * @type {string}
     */
    this.path = socket.upgradeReq.url.substr(1).split('/');

    /**
     *
     * @type {string}
     */
    this.origin = socket.upgradeReq.headers.origin;

    /**
     *
     * @type {string}
     */
    this.userId = null;
}

/**
 *
 * @returns {{}}
 */
Client.prototype.getCookies = function() {
    return cookie.parse(this.socket.upgradeReq.headers.cookie || '');
};

/**
 *
 * @param {string} eventName
 * @param {Function} callbackFn
 * @returns {EventEmitter}
 */
Client.prototype.on = function(eventName, callbackFn) {
    return this.socket.on(eventName, callbackFn);
};

/**
 *
 * @param {string} eventName
 * @param {*} data
 */
Client.prototype.sendEvent = function (eventName, data) {
    let event = { event: eventName };

    event[eventName] = data;

    this.send(event);
};

/**
 *
 * @param {string} error
 */
Client.prototype.sendError = function(error) {
    this.sendEvent('error', error);
};

/**
 *
 * @param {*} data
 */
Client.prototype.send = function (data) {
    if (typeof data === 'object') {
        data = JSON.stringify(data);
    }

    this.socket.send(data);
};

/**
 *
 * @param {string} [error]
 */
Client.prototype.close = function(error) {
    if (error !== undefined) {
        this.sendError(error);
    }

    this.socket.close();
};

module.exports = Client;