/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const fetch = require('node-fetch');

/**
 * @param {string} sessionId
 * @param {string} origin
 * @returns {Promise<string>}
 */
function getUserFromSession(sessionId, origin) {
    return fetch(`${origin}/session/${sessionId}`, { headers: { 'User-Agent': 'GankedSocketBot/1.0' }})
        .then(resp => resp.json())
        .then(data => {
            if (!data.status) {
                return;
            }

            return data.id;
        });
}

module.exports = getUserFromSession;