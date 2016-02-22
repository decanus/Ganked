/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import Symbol from 'es6-symbol';
import { forEach } from '../utils/for-each';
import { createElement } from '../dom/create-element';
import { document } from '../dom/document/document';
import { onReady } from '../dom/document/on-ready';
import { selectInScope } from '../dom/select-in-scope';
import { getBox } from '../dom/box';
import { CoreElement } from './core';
import { setBooleanAttribute } from '../dom/set-boolean-attribute';
import { fixedElements } from '../core/fixed-elements';

/**
 *
 * @type {Symbol}
 */
const target = Symbol('$target');

/**
 *
 * @type {Symbol}
 */
const listener = Symbol('listener');

/**
 *
 * @type {number}
 */
const arrowHeight = 14;

/**
 *
 * @type {number}
 */
const arrowOffset = 18;

/**
 *
 * @type {number}
 */
let hideTimeout;

/**
 * @type {InfoBox}
 */
let active;

class InfoBox extends CoreElement {
    createdCallback() {
        /**
         *
         * @type {HTMLElement,null}
         */
        this[target] = null;

        /**
         *
         * @type {HTMLElement}
         */
        this.$arrow = createElement(document(this), 'div', {
            'class': 'arrow'
        });

        /**
         *
         * @type {boolean}
         */
        this.hidden = true;

        this.addEventListener('mouseover', () => this.show());
        this.addEventListener('mouseout', () => this.hide());
        this.appendChild(this.$arrow);
    }

    /**
     *
     * @param {HTMLElement} $target
     */
    attach($target) {
        this[target] = $target;
        this.attached = true;
    }

    /**
     *
     * @returns {HTMLElement,null}
     */
    get $target() {
        return this[target];
    }

    /**
     *
     * @returns {boolean}
     */
    get attached() {
        return this.hasAttribute('attached');
    }

    /**
     *
     * @returns {string}
     */
    get position() {
        return this.getAttribute('position');
    }

    /**
     *
     * @param {string} value
     */
    set position(value) {
        this.setAttribute('position', value);
    }

    /**
     *
     * @param {boolean} value
     */
    set attached(value) {
        if (!value) {
            this[target] = null;
        }

        setBooleanAttribute(this, 'attached', value);
    }

    show() {
        if (hideTimeout) {
            clearTimeout(hideTimeout);
        }

        if (active !== this && active) {
            active.hide();
        }

        active = this;
        this.hidden = false;
        this._updatePosition();
        this._addWindowListeners();
    }

    /**
     *
     * @param {number} delay
     */
    hide(delay = 100) {
        hideTimeout = setTimeout(() => {
            this.hidden = true;
            this._removeWindowListeners();
        }, delay);
    }

    _updatePosition() {
        let targetBox, box, arrowWidth, center, left, top;

        targetBox = getBox(this.$target);
        box = this.getBox();
        arrowWidth = getBox(this.$arrow).width;

        center = targetBox.position.left + (targetBox.width / 2) - (arrowWidth / 2);

        if (targetBox.position.top - box.height - arrowHeight >= fixedElements.getMaximumTopOffset()) {
            this.position = 'top';
            top = (targetBox.position.top - box.height - arrowHeight);
        } else {
            this.position = 'bottom';
            top = (targetBox.position.top + targetBox.height + arrowHeight);
        }

        left = center - arrowOffset;

        if (left + box.width > window.innerWidth) {
            left = left - box.width + arrowWidth + arrowOffset * 2;
        }

        // catch negative viewport overflow
        if (left < 0) {
            left = 0;
        }

        this.style.top = top + 'px';
        this.style.left = left + 'px';

        this.$arrow.style.left = (center - left) + 'px';
    }

    /**
     *
     * @private
     */
    _addWindowListeners() {
        let callbackFn = () => this._updatePosition();

        window.addEventListener('scroll', callbackFn);
        window.addEventListener('resize', callbackFn);

        this._removeWindowListeners();
        this[listener] = callbackFn;
    }

    /**
     *
     * @private
     */
    _removeWindowListeners() {
        let callbackFn = this[listener];

        if (callbackFn) {
            window.removeEventListener('scroll', callbackFn);
            window.removeEventListener('resize', callbackFn);
        }
    }
}

/**
 *
 * @param {HTMLElement} $scope
 */
export function scan($scope) {
    let $targets = $scope.querySelectorAll('[data-info-box]');

    forEach($targets, ($target) => {
        let $box = selectInScope($target, $target.dataset.infoBox);

        $target.addEventListener('mouseover', () => {
            $box.attach($target);
            $box.show();
        });

        $target.addEventListener('mouseout', () => $box.hide());
    });
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('info-box', InfoBox);

    onReady().then(() => {
        scan(document);
    });
}