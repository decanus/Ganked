/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const notFound = require('./controllers/not-found'),
      notifications = require('./controllers/notifications');

/**
 *
 * @param {string} path
 * @returns {Function}
 */
function route(path) {
    switch(path) {
        case '/notifications':
            return notifications;
    }

    return notFound;
}

module.exports = route;