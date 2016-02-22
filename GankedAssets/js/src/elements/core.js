/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { Box } from '../dom/box';
import { setBooleanAttribute } from '../dom/set-boolean-attribute';

export class CoreElement {
    /**
     *
     * @api
     * @returns {boolean}
     */
    get hidden() {
        return this.hasAttribute('hidden');
    }

    /**
     *
     * @api
     * @param {boolean} hidden
     */
    set hidden(hidden) {
        //noinspection JSCheckFunctionSignatures
        setBooleanAttribute(this, 'hidden', hidden);
    }

    /**
     *
     * @api
     * @returns {Box}
     */
    getBox() {
        //noinspection JSCheckFunctionSignatures
        return new Box(this);
    }

    /**
     *
     * @api
     */
    empty() {
        this.innerHTML = '';
    }

    /**
     * Forces the element to re-render.
     *
     * @todo refactor this behavior using events
     * @internal
     */
    render() {

    }
}

Object.setPrototypeOf(CoreElement.prototype, HTMLElement.prototype);