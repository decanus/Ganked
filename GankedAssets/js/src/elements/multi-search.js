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
    " joined the room.",
    " joined the group.",
    " entró a la sala.",
    " entrou na sala.",
    " 님이 입장하셨습니다.",
    "님이 방에 참가했습니다."
];

/**
 *
 * @param {string} input
 * @returns {string}
 */
function getSummonerNamesFromRawInput(input) {
    let lines, names;

    lines = input.split("\n");
    names = lines.map((line) => {
        if (line.indexOf(':') > -1) {
            // it's a chat message, so we use everything before the 1st colon.
            return line.split(':')[0];
        }

        for (let i = 0; i < DELIMITERS.length; i++) {
            let msg = DELIMITERS[i];

            if (line.indexOf(msg) > -1) {
                return line.split(msg)[0];
            }
        }

        return line;
    });

    return unique(names)
        .map((v) => v.trim())
        .filter((v) => v !== '')
        .join(', ');
}

class MultiSearch {
    /**
     * @internal
     */
    createdCallback() {
        this.addEventListener('paste', (e) => {
            e.preventDefault();

            this.value += getSummonerNamesFromRawInput(getClipboardData(e));
        });
    }
}

Object.setPrototypeOf(MultiSearch.prototype, HTMLInputElement.prototype);

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('multi-search', {
        prototype: MultiSearch.prototype,
        'extends': 'input'
    });
}