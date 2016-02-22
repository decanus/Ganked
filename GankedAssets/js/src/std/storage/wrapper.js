/**
 * (c) 2015 Ganked
 */

import Symbol from 'es6-symbol';
import { getIterator } from './iterator';

/**
 *
 * @type {Symbol}
 */
export const native = Symbol('native');


/**
 * @callback forEachCallback
 * @param {*} value
 * @param {string} key
 * @param {StorageWrapper} storage
 */

/**
 * @class StorageWrapper
 * @extends {Iterable.<Array>}
 */
export class StorageWrapper {
    /**
     *
     * @param {Storage} storage
     */
    constructor(storage) {
        /**
         *
         * @type {Storage}
         */
        this[native] = storage;
    }

    /**
     *
     * @param {string} key
     */
    get(key) {
        let item = this[native].getItem(key);

        if (item === null) {
            throw new RangeError(`key ${key} not found in storage`);
        }

        return JSON.parse(item);
    }

    /**
     *
     * @param {string} key
     * @param {*} value
     */
    set(key, value) {
        this[native].setItem(key, JSON.stringify(value));
    }

    /**
     *
     * @param {string} key
     */
    ['delete'](key) {
        this[native].removeItem(key);
    }

    /**
     *
     * @param {string} key
     */
    remove(key) {
        this.delete(key);
    }

    /**
     *
     * @param {string} key
     * @returns {boolean}
     */
    has(key) {
        try {
            this.get(key);
            return true;
        } catch (_) {
            return false;
        }
    }

    clear() {
        this[native].clear();
    }

    /**
     *
     * @returns {StorageIterator}
     */
    entries() {
        return getIterator(this, 'key+value');
    }

    /**
     *
     * @returns {StorageIterator}
     */
    keys() {
        return getIterator(this, 'key');
    }

    /**
     *
     * @returns {StorageIterator}
     */
    values() {
        return getIterator(this, 'value');
    }

    /**
     * @param {forEachCallback} callbackFn
     */
    forEach(callbackFn) {
        for (let [key, value] of this) {
            callbackFn(value, key, this);
        }
    }

    /**
     *
     * @returns {Map}
     */
    toMap() {
        return new Map(this);
    }

    /**
     *
     * @returns {StorageIterator}
     */
    [Symbol.iterator]() {
        return this.entries();
    }

    /**
     *
     * @returns {number}
     */
    get size() {
        return this[native].length;
    }
}

/**
 *
 * @returns {StorageWrapper}
 */
export function getLocalStorage() {
    return new StorageWrapper(window.localStorage);
}

/**
 *
 * @returns {StorageWrapper}
 */
export function getSessionStorage() {
    return new StorageWrapper(window.sessionStorage);
}

window.getLocalStorage = getLocalStorage;