/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

/**
 *
 * @type {{}}
 */
const defaultHeaders = { 'Content-Type': 'application/json' };

/**
 *
 * @param {http.ServerResponse} res
 * @param {number} status
 * @param {{}} body
 * @param {{}} [headers]
 *
 * @returns {http.ServerResponse}
 */
function writeResponse(res, status, body, headers) {
    body = JSON.stringify(body);
    headers = headers || {};

    res.writeHead(status, Object.assign({}, defaultHeaders, headers));
    res.end(body);

    return res;
}

/**
 *
 * @param {Function} handler
 * @returns {Function}
 */
function wrapHandler(handler) {
    let args = Array.from(arguments).slice(1);

    return (req, res) => {
        let result = handler.apply(null, [req].concat(args));

        result.then(response => writeResponse(res, 200, response.data, response.headers));
        result.catch(error => writeResponse(res, error.status, { error: error.message }));
    };
}

module.exports = wrapHandler;