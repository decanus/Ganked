/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

'use strict';

const env = process.env;

/**
 *
 * @returns {{port: number}}
 */
function getCloudFoundryConfig() {
    return {
        port: env.VCAP_APP_PORT
    };
}

/**
 *
 * @returns {{port: number, gcmApiKey: string}}
 */
module.exports = function getConfiguration() {
    let config = require('../config/system.json');

    if (env.VCAP_APPLICATION) {
        return Object.assign({}, config, getCloudFoundryConfig());
    }

    return config;
};