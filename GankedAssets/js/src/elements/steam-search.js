/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { forEach } from '../utils/for-each';
import { getClipboardData } from '../dom/clipboard/get-clipboard-data';
import { unique } from '../std/array/unique';

/**
 *
 * @type {string[]}
 */
const DELIMITERS = [
    "http://steamcommunity.com/id/",
    "http://steamcommunity.com/profiles/",
    "https://steamcommunity.com/id/",
    "https://steamcommunity.com/profiles/"
];

/**
 *
 * @param {string} input
 * @returns {string}
 */
function getSearchTermFromSteamUri(input) {
    for (let i = 0; i < DELIMITERS.length; i++) {
        let msg = DELIMITERS[i];

        if (input.toLowerCase().indexOf(msg) > -1) {
            return input.toLowerCase().replace(msg, '').replace(/\/$/, '');
        }
    }

    return input;
}

class SteamSearch {
    /**
     * @internal
     */
    createdCallback() {
        this.addEventListener('paste', e => {
            e.preventDefault();

            this.value += getSearchTermFromSteamUri(getClipboardData(e));
        });
    }
}

Object.setPrototypeOf(SteamSearch.prototype, HTMLInputElement.prototype);

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('steam-search', {
        prototype: SteamSearch.prototype,
        'extends': 'input'
    });
}