/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { Engine } from '../search/engine';
import { ChampionProvider } from '../search/champion-provider';
import Symbol from 'es6-symbol';

import { parseFragment } from '../dom/parse-fragment';
import { isDescendant } from '../dom/is-descendant';
import { Box } from '../dom/box';
import { CoreElement } from './core';

/**
 * @type {symbol}
 */
const input = Symbol('input'),
    engine = Symbol('engine'),
    attach = Symbol('attach');

/**
 *
 * @param {Element} $target
 */
let createKeyboardListeners = function($target) {
    $target.addEventListener('keydown', (e) => {
        switch(e.keyCode) {
            case 40:
                e.preventDefault();
                this.$next.focus();
                break;
            case 38:
                this.$prev.focus();
                e.preventDefault();
                break;
            case 13:
                break;
            case 27:
                this.hidden = true;
                break;
            default:
                this.$input.focus();
        }
    });

    $target.addEventListener('blur', () => {
        let $focus = document.querySelector(':focus');

        if ($focus === null || (!isDescendant(this, $focus) && $focus !== this.$input)) {
            setTimeout(() => this.hidden = true, 100);
        }
    });

    $target.addEventListener('focus', () => {
        this.hidden = false;
        setTimeout(() => this.hidden = false, 100);
    });
};

class SearchSuggestions extends CoreElement {
    createdCallback() {
        this[engine] = new Engine();
        this[engine].addProvider('champion', new ChampionProvider());

        this[input] = document.querySelector(this.for);
        this[attach] = this[input];

        if (this.attach) {
            this[attach] = document.querySelector(this.attach);
        }

        this.$input.addEventListener('input', () => {
            this.updateSuggestions(this.$input.value);
        });

        createKeyboardListeners.call(this, this.$input);

        window.addEventListener('scroll', () => this.updateBox());
        window.addEventListener('resize', () => this.updateBox());

        this.updateSuggestions(this.$input.value);
        this.hidden = true;
        this.updateBox();
    }

    updateBox() {
        let box = new Box(this[attach]),
            inputBox = new Box(this.$input);

        this.style.left = inputBox.position.left + 'px';
        this.style.top = inputBox.position.bottom + 'px';
        this.style.width = box.width + 'px';
    }

    /**
     *
     * @param {string} search
     */
    updateSuggestions(search) {
        this.updateBox();
        this.hidden = false;
        this.innerHTML = '';

        this[engine].search(search, (ret) => {
            let items = ret.items;

            items.forEach((item) => {
                let $item = parseFragment(
                    `<a class="search-suggestion" href="${item.href}">
                        <img class="image" src="${item.image}" alt="${item.title}" />
                        <span class="text">
                            <h3 class="title">${item.title}</h3>
                            <p class="description">${item.description}</p>
                        </span>
                    </a>`
                );

                createKeyboardListeners.call(this, $item);
                this.appendChild($item);
            });
        });
    }

    /**
     *
     * @returns {string}
     */
    get ['for']() {
        return this.getAttribute('for');
    }

    /**
     *
     * @returns {string}
     */
    get attach() {
        return this.getAttribute('attach');
    }

    /**
     *
     * @returns {HTMLElement}
     */
    get $input() {
        return this[input];
    }

    /**
     *
     * @returns {Element}
     */
    get $current() {
        return this.querySelector('.search-suggestion:focus');
    }

    /**
     *
     * @returns {Element}
     */
    get $first() {
        return this.querySelector('.search-suggestion');
    }

    /**
     *
     * @returns {Element}
     */
    get $next() {
        let $current = this.$current;

        if ($current) {
            return $current.nextElementSibling;
        }

        return this.$first;
    }

    /**
     *
     * @returns {Element}
     */
    get $prev() {
        let $current = this.$current;

        if ($current) {
            return $current.previousElementSibling || this.$input;
        }
    }

    /**
     *
     * @returns {Engine}
     */
    get engine() {
        return this[engine];
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('search-suggestions', SearchSuggestions);
}