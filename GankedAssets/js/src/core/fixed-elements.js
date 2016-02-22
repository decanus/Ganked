/**
 * (c) 2015 Ganked <ganked.net>
 */

import { Box } from '../dom/box';
import Symbol from 'es6-symbol';

/**
 *
 * @type {Symbol}
 */
const data = Symbol('data');

class FixedElementsRegistry {
    constructor() {
        /**
         * @type {Map}
         */
        this[data] = new Map();
    }

    /**
     *
     * @param {Element} $element
     */
    add($element) {
        let box = new Box($element);

        this[data].set($element, box.position.top + box.height);
    }

    /**
     *
     * @returns {number}
     */
    getMaximumTopOffset() {
        let max = 0;

        this[data].forEach((pos) => {
            if (pos > max) {
                max = pos;
            }
        });

        return max;
    }
}

export let fixedElements = new FixedElementsRegistry();