/**
 * (c) 2015 Ganked <ganked.net>
 */

import Symbol from 'es6-symbol';

/**
 *
 * @type {Symbol}
 */
const clientRect = Symbol('clientRect');

/**
 *
 * @type {Symbol}
 */
const style = Symbol('style');

/**
 *
 * @type {Symbol}
 */
const margin = Symbol('margin');

/**
 *
 * @type {Symbol}
 */
const padding = Symbol('padding');

export class Box {
    /**
     *
     * @param {HTMLElement} $
     */
    constructor($) {
        /**
         *
         * @type {HTMLElement}
         */
        this.$ = $;
    }

    /**
     *
     * @returns {ClientRect}
     */
    get clientRect() {
        if (!this[clientRect]) {
            this[clientRect] = this.$.getBoundingClientRect();
        }

        return this[clientRect];
    }

    /**
     *
     * @returns {CSSStyleDeclaration}
     */
    get style() {
        if (!this[style]) {
            this[style] = getComputedStyle(this.$);
        }

        return this[style];
    }

    /**
     *
     * @returns {Number}
     */
    get width() {
        return this.clientRect.width;
    }

    /**
     *
     * @returns {Number}
     */
    get height() {
        return this.clientRect.height;
    }

    /**
     *
     * @returns {{top: Number, right: Number, bottom: Number, left: Number}}
     */
    get position() {
        return {
            top: this.clientRect.top,
            right: this.clientRect.right,
            bottom: this.clientRect.bottom,
            left: this.clientRect.left
        };
    }

    /**
     *
     * @returns {{top: Number, right: Number, bottom: Number, left: Number}}
     */
    get margin() {
        if (!this[margin]) {
            this[margin] = {
                top: parseFloat(this.style.marginTop),
                right: parseFloat(this.style.marginRight),
                bottom: parseFloat(this.style.marginBottom),
                left: parseFloat(this.style.marginLeft)
            };
        }

        return this[margin];
    }

    /**
     *
     * @returns {{top: Number, right: Number, bottom: Number, left: Number}}
     */
    get padding() {
        if (!this[padding]) {
            this[padding] = {
                top: parseFloat(this.style.paddingTop),
                right: parseFloat(this.style.paddingRight),
                bottom: parseFloat(this.style.paddingBottom),
                left: parseFloat(this.style.paddingLeft)
            };
        }

        return this[padding];
    }
}

/**
 *
 * @param {HTMLElement} $
 */
export function getBox($) {
    return new Box($);
}

export default getBox;