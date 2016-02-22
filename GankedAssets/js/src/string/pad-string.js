/**
 * (c) 2015 Ganked <ganked.net>
 */

import { repeatString } from './repeat-string';

/**
 *
 * @param {*} string
 * @param {string} char
 * @param {number} length
 * @param {string} position
 */
export function padString(string, char, length, position = 'left') {
    string = String(string);

    let pad = repeatString(char, length - string.length);

    if (position === 'right') {
        return string + pad;
    }

    return pad + string;
}