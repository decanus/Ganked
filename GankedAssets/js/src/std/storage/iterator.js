/**
 * (c) 2015 Ganked
 */
import { native } from './wrapper';

/**
 *
 * @type {Symbol}
 */
const pointer = Symbol('pointer');

/**
 *
 * @param {StorageIterator} iterator
 * @returns {*|*[]}
 */
function getIteratorValue(iterator) {
    let key = iterator.storage[native].key(iterator[pointer]), value,
        kind = iterator.kind;

    if (kind === 'key') {
        return key;
    }

    value = iterator.storage.get(key);

    if (kind === 'value') {
        return value;
    }

    return [key, value];
}

/**
 * @class StorageIterator
 * @extends {Iterator.<*>}
 * @extends {Iterable.<Array>}
 */
class StorageIterator {
    /**
     *
     * @param {StorageWrapper} storage
     * @param {string} kind
     */
    constructor(storage, kind) {
        Object.defineProperty(this, 'storage', { value: storage });
        Object.defineProperty(this, 'kind', { value: kind });

        /**
         *
         * @type {number}
         */
        this[pointer] = 0;
    }

    /**
     * @return {{ done: boolean, value: * }}
     */
    next() {
        let i = this[pointer], data;

        if(this.storage.size === 0) {
            return { done: true };
        }

        if (this.storage.size === i) {
            return { done: true };
        }

        data = getIteratorValue(this);

        this[pointer]++;

        return { done: false, value: data };
    }

    /**
     *
     * @returns {StorageIterator}
     */
    [Symbol.iterator]() {
        return new StorageIterator(this.storage, this.kind);
    }

    /**
     *
     * @returns {Array}
     */
    toArray() {
        return [...this];
    }
}

/**
 *
 * @param {StorageWrapper} storage
 * @param {string} kind
 * @returns {StorageIterator}
 */
export function getIterator(storage, kind) {
    return new StorageIterator(storage, kind);
}