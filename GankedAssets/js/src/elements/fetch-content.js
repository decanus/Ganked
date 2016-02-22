/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { forEach } from '../utils/for-each';
import Symbol from 'es6-symbol';
import { Promise } from 'es6-promise';
import { CoreElement } from './core';

const fetched = Symbol('fetched');

const errorSnippet = `<div class="error generic-box -noMargin -fit">
    <h2>Error</h2>
    <p>Sorry, we couldn't load the page.<br />
    Please try to reload the page.<br /> If the error persists please contact the
    <a href="mailto:webmaster@ganked.net">Webmaster</a>.
    </p>
    <button data-action="fetch-content:reload">Reload</button>
    </div>`;

class Fetch extends CoreElement {
    createdCallback() {
        this.status = '';
        this[fetched] = false;

        if (this.lazy) {
            this.status = 'lazy';
            return;
        }

        if (this.href) {
            this.fetch();
        }
    }

    /**
     *
     * @returns {Promise}
     */
    fetch() {
        if (this[fetched]) {
            return Promise.resolve(this);
        }

        this.status = 'pending';
        this.error = '';

        return new Promise((resolve, reject) => {
            window.fetch(this.href).then(function (resp) {
                if (resp.status < 200 || resp.status >= 400) {
                    return Promise.reject(resp.status);
                }

                return resp.text();
            }).then((body) => {
                this.innerHTML = body;
                this.status = 'done';
                this[fetched] = true;

                this._registerActions();
                this.dispatchEvent(new CustomEvent('fetched'));

                resolve(this);
            }).catch((error) => {
                this.innerHTML = errorSnippet;
                this.status = 'error';
                this.error = String(error);

                this._registerActions();
                this.dispatchEvent(new CustomEvent('error'));

                reject(this.error, this);
            });
        });
    }

    _registerActions() {
        forEach(this.querySelectorAll('[data-action="fetch-content:reload"]'), ($target) => {
            $target.addEventListener('click', () => {
                this.reload();
            });
        });
    }

    /**
     *
     * @returns {Promise}
     */
    reload() {
        this[fetched] = false;

        return this.fetch();
    }

    /**
     *
     * @param {string} name
     * @param {string} oldValue
     * @param {string} newValue
     */
    attributeChangedCallback(name, oldValue, newValue) {
        if (name === 'href') {
            this.href = newValue;
        }
    }

    /**
     *
     * @returns {string}
     */
    get href() {
        return this.getAttribute('href');
    }

    /**
     *
     * @param {string} value
     */
    set href(value) {
        if (this.href === value) {
            return;
        }

        this.setAttribute('href', value);
        this.reload();
    }

    /**
     *
     * @param {string} value
     */
    set status(value) {
        if (this.status !== value) {
            this.setAttribute('status', value);

            this.dispatchEvent(new CustomEvent('statusChange', {
                detail: { status: this.status }
            }));
        }
    }

    /**
     *
     * @returns {string}
     */
    get status() {
        return this.getAttribute('status');
    }

    /**
     *
     * @returns {boolean}
     */
    get lazy() {
        return this.hasAttribute('lazy');
    }

    /**
     *
     * @returns {string}
     */
    get error() {
        return this.getAttribute('error');
    }

    /**
     *
     * @param {string} string
     */
    set error(string) {
        if (string === '') {
            return this.removeAttribute('error');
        }

        this.setAttribute('error', string);
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('fetch-content', Fetch);
}