/**
 * (c) 2015 Ganked
 */

import { insertFirstChild } from '../../../js/src/dom/insert-first-child';
import assert from 'assert';

describe('insertFirstChild()', () => {
    it('inserts before the first child', () => {
        let fragment = document.createDocumentFragment(),
            h1 = fragment.appendChild(document.createElement('h1')),
            h3 = insertFirstChild(document.createElement('h3'), fragment);

        assert.equal(h1.previousSibling, h3);
        assert.equal(fragment.firstChild, h3);
    });

    it('inserts as last child if the parent has no children', () => {
        let fragment = document.createDocumentFragment(),
            h3 = insertFirstChild(document.createElement('h3'), fragment);

        assert.equal(fragment.firstChild, h3);
        assert.equal(fragment.lastChild, h3);
    });

    it('returns the appended node', () => {
        let fragment = document.createDocumentFragment(),
            h3 = document.createElement('h3'),
            h1 = document.createElement('h1');

        assert.equal(insertFirstChild(h3, fragment), h3);
        assert.equal(insertFirstChild(h1, fragment), h1);
    });
});