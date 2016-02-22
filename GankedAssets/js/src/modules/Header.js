/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { forEach } from '../utils/for-each';
import { onReady } from '../dom/document/on-ready';
import { getBox } from '../dom/box';
import { insertAfter } from '../dom/insert-after';
import { insertFirstChild } from '../dom/insert-first-child';
import { getScrollTop } from '../dom/document/get-scroll-top';
import { limitNumber } from '../math/limit-number';
import { fixedElements } from '../core/fixed-elements';

export class Header {
    /**
     *
     * @param {Element} $
     * @param {number} destination
     * @param {boolean} updateBackground
     * @param {string} [containerName]
     */
    constructor($, destination, updateBackground, containerName = "") {
        /**
         *
         * @type {Element}
         */
        this.$ = $;

        /**
         *
         * @type {Element}
         */
        this.$inner = $.querySelector(':scope > .inner');

        /**
         *
         * @type {number}
         */
        this.destination = destination;

        /**
         *
         * @type {boolean}
         */
        this.updateBackground = updateBackground;

        /**
         *
         * @type {Element}
         */
        this.$placeholder = document.createElement('div');

		/**
		 * @type {string}
		 */
		this.containerName = containerName;

        window.addEventListener('scroll', () => {
            this.update();
        });

        window.addEventListener('resize', () => {
            this.update();
            this.updatePlaceholder();
        });

        this.update();
        this.appendPlaceholder();
        this.updatePlaceholder();
        this.stick();
    }

    stick() {
        this.$.classList.add('-fixed');
        fixedElements.add(this.$);
    }

    appendPlaceholder() {
        let $container = document.querySelector(`[data-fixed-header-container="${this.containerName}"]`);

        if ($container) {
            return insertFirstChild(this.$placeholder, $container);
        }

        insertAfter(this.$placeholder, this.$);
    }

    update() {
        if (!this.updateBackground) {
            return false;
        }

        this.$.style.backgroundColor = Header.getColor(
            limitNumber(getScrollTop() / window.innerHeight * 3, 0, 1)
        );
    }

    updatePlaceholder() {
        let box = getBox(this.$);

        this.$placeholder.style.height = `${box.height}px`;
        fixedElements.add(this.$);
    }

    /**
     *
     * @param {number} opacity
     * @returns {string}
     */
    static getColor(opacity) {
        return `rgba(24, 34, 43, ${opacity})`;
    }
}

/**
 *
 * @param {string} selector
 * @param {boolean} updateBackground
 */
export default function (selector, updateBackground = true, containerName = "") {
    onReady().then(function () {
        let $headers = document.querySelectorAll(selector);

        forEach($headers, function ($header) {
            let header = new Header($header, 15000, updateBackground, containerName);
        });
    });
}
