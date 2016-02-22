/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { CoreElement } from './core';
import { setBooleanAttribute } from '../dom/set-boolean-attribute';
import { animateToAutoHeight } from '../std/animate/to-auto-height';
import { animateFromAutoHeight } from '../std/animate/from-auto-height';
import { getAnimationFrame } from '../std/animation/get-animation-frame';

class AdditionalContent extends CoreElement {
    /**
     * @api
     */
    toggle() {
        if (this.visible) {
            return this.hide();
        }

        return this.show();
    }

    /**
     * @api
     * @returns {Promise<AdditionalContent>}
     */
    show() {
        //noinspection JSCheckFunctionSignatures
        return animateToAutoHeight(this).then(getAnimationFrame).then(() => {
            this.visible = true;
            return this;
        });
    }

    /**
     * @api
     * @returns {Promise<AdditionalContent>}
     */
    hide() {
        //noinspection JSCheckFunctionSignatures
        return animateFromAutoHeight(this).then(() => {
            this.visible = false;
            return this;
        });
    }

    /**
     *
     * @internal
     * @returns {boolean}
     */
    get visible() {
        return this.hasAttribute('visible');
    }

    /**
     *
     * @internal
     * @param {boolean} visible
     */
    set visible(visible) {
        //noinspection JSCheckFunctionSignatures
        setBooleanAttribute(this, 'visible', visible);
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function additionalContent(document) {
    document.registerElement('additional-content', AdditionalContent);
}