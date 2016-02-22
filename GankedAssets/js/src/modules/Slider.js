/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { forEach } from '../utils/for-each';
import { forOwn } from '../utils/for-own';
import { onReady } from '../dom/document/on-ready';

let create = Object.create;

const defaultOptions = Object.seal({
    itemSelector: ':scope > .inner > .item',
    innerSelector: ':scope > .inner',
    activeClass: '-active',
    buttonDisabledClass: '-disabled',
    pagination: false // Todo
});

/**
 *
 * @param {{}} obj
 *
 * @returns {{}}
 */
let createDescriber = function (obj) {
    var ret = {};

    forOwn(obj, function (value, key) {
        ret[key] = {value};
    });

    return ret;
};

class Cycle {
    constructor() {
        /**
         *
         * @type {Array}
         */
        this.pages = [];

        this.reset();
    }

    reset() {
        /**
         *
         * @type {Array}
         */
        this.page = [];
        this.pages.push(this.page);

        /**
         *
         * @type {number}
         */
        this.x = 0;
    }
}

/**
 * Todo: events
 * Todo: mutation observer
 * Todo: active classes
 * Todo: pagination
 */
export class Slider {
    /**
     *
     * @param {Element} $target
     * @param {{}} options
     */
    constructor($target, options = {}) {
        /**
         *
         * @type {defaultOptions}
         */
        this.options = create(defaultOptions, createDescriber(options));

        /**
         *
         * @type {Element}
         */
        this.$ = $target;

        /**
         *
         * @type {{next: Set, prev: Set}}
         */
        this.controls = {
            next: new Set(),
            prev: new Set()
        };

        /**
         *
         * @type {number}
         */
        this.current = 0;

        /**
         *
         * @type {number}
         * @private
         */
        this._translateLeft = 0;

        this._initDom();
    }

    /**
     * @return Set
     */
    get pages() {
        let width, $items, cycle;

        cycle = new Cycle();
        width = this.$inner.getBoundingClientRect().width;
        $items = this.$items;

        $items.forEach(function ($item) {
            let itemWidth = $item.getBoundingClientRect().width;

            if (cycle.x + itemWidth > width) {
                cycle.reset();
            }

            cycle.x += itemWidth;
            cycle.page.push($item);
        });

        return cycle.pages;
    }

    /**
     *
     * @private
     */
    _initDom() {
        forOwn(this.controls, (list, type) => {
            forEach(this.$.querySelectorAll(`[role="slider:${type}"]`), ($control) => {
                if (!list.has($control)) {
                    list.add($control);

                    $control.addEventListener('click', () => {
                        this[type]();
                    });
                }
            });
        });

        this.$inner.addEventListener('transitionend', () => {
            this._updateActiveClasses();
        });

        window.addEventListener('resize', () => {
            this.update(true);
        });

        this.update();
    }

    /**
     *
     * Updates the DOM of the slider. Call this function if you
     * modify the DOM and the slider isn't updated.
     *
     * @param {boolean} disableTransitions
     * @api
     */
    update(disableTransitions = false) {
        let update = (done) => {
            let pages = this.pages,
                page = this.page;

            this.current = this.$items.indexOf(pages[page][0]);

            this._setTranslateLeft(this._getTranslateLeft());

            let prevAction = this.current === 0 ? 'add' : 'remove';

            this.controls.prev.forEach(($control) => {
                $control.classList[prevAction](this.options.buttonDisabledClass);
            });

            let nextAction = (page === pages.length - 1) ? 'add' : 'remove';

            this.controls.next.forEach(($control) => {
                $control.classList[nextAction](this.options.buttonDisabledClass);
            });

            done();
        };

        if (disableTransitions) {
            this._withoutTransition(update);
        } else {
            update(() => {});
        }
    }

    /**
     *
     * @param {Number} left
     * @private
     */
    _setTranslateLeft(left) {
        this._translateLeft = left;

        this.$inner.style.oTransform = `translate3d(${-left}px, 0, 0)`;
        this.$inner.style.msTransform = `translate3d(${-left}px, 0, 0)`;
        this.$inner.style.mozTransform = `translate3d(${-left}px, 0, 0)`;
        this.$inner.style.webkitTransform = `translate3d(${-left}px, 0, 0)`;
        this.$inner.style.transform = `translate3d(${-left}px, 0, 0)`;
    }

    /**
     *
     * @returns {number}
     * @private
     */
    _getTranslateLeft() {
        return this.$current.offsetLeft - this.$inner.offsetLeft;
    }

    /**
     *
     * @param {Function} callbackFn
     * @private
     */
    _withoutTransition(callbackFn) {
        this.$inner.style.transition = 'none';

        callbackFn(() => {
            this.$inner.style.transition = '';
        });
    }

    /**
     *
     * @private
     */
    _updateActiveClasses() {
        this.$items.forEach(($item) => {
            $item.classList.remove(this.options.activeClass);
        });

        this.$visible.forEach(($item) => {
            $item.classList.add(this.options.activeClass);
        });
    }

    /**
     *
     * @returns {number}
     */
    next() {
        this.page += 1;

        return this.current;
    }

    /**
     *
     * @returns {number}
     */
    prev() {
        this.page -= 1;

        return this.current;
    }

    /**
     *
     * @returns {number}
     */
    get page() {
        let page, pages = this.pages,
            $current = this.$current;

        pages.forEach(function (p, i) {
            if (p.indexOf($current) !== -1) {
                page = i;
            }
        });

        return page;
    }

    /**
     *
     * @param {number} index
     */
    set page(index) {
        let pages = this.pages;

        if (pages[index]) {
            this.current = this.$items.indexOf(pages[index][0]);
            this.update();
        }
    }

    /**
     *
     * @returns {Array}
     */
    get $items() {
        return Array.from(this.$.querySelectorAll(this.options.itemSelector));
    }

    /**
     * Returns all the items currently in view
     */
    get $visible() {
        let $items = this.$items;

        let rect = this.$inner.getBoundingClientRect(),
            right = rect.right + this._translateLeft,
            left = rect.left + this._translateLeft;

        let current = [];

        $items.forEach(function ($item) {
            let bounding = $item.getBoundingClientRect();

            if (bounding.left >= left && Math.round(bounding.right) <= Math.round(right)) {
                current.push($item);
            }
        });

        return current;
    }

    /**
     *
     * @returns {Element}
     */
    get $current() {
        return this.$items[this.current];
    }

    /**
     *
     * @returns {Element}
     */
    get $inner() {
        return this.$.querySelector(this.options.innerSelector);
    }
}

export default function () {
    onReady().then(function () {
        forEach(document.querySelectorAll('.slider-box'), function ($slider) {
            let slider = new Slider($slider);
        });
    });
}