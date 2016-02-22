/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

/**
 *
 * @param {http.IncomingMessage} request
 * @param {number} [maxLength]
 * @returns {Promise<string>}
 */
function getRequestBody(request, maxLength) {
    if (maxLength === undefined) {
        maxLength = 1e6; // ~~~ 1 MB
    }

    return new Promise((resolve, reject) => {
        let body = '';

        request.on('data', chunk => {
            body += chunk;

            if (body.length > maxLength) {
                request.connection.destroy();
                reject('too much data');
            }
        });

        request.once('end', () => resolve(body));
    });
}

module.exports = getRequestBody;