/**
 * (c) 2015 Ganked
 */

import { insertAfter } from '../../../js/src/dom/insert-after';
import assert from 'assert';

describe('insertAfter()', () => {
    it('inserts after the reference node', () => {
        let fragment = document.createDocumentFragment(),
            h1 = fragment.appendChild(document.createElement('h1'));

        fragment.appendChild(document.createElement('h2'));

        let h3 = insertAfter(document.createElement('h3'), h1);

        assert.equal(h1.nextSibling, h3);
    });

    it('inserts as last child if the ref node is the last', () => {
        let fragment = document.createDocumentFragment(),
            h1 = fragment.appendChild(document.createElement('h1')),
            h3 = insertAfter(document.createElement('h3'), h1);

        assert.equal(fragment.lastChild, h3);
    });

    it('returns the inserted node', () => {
        let fragment = document.createDocumentFragment(),
            h1 = fragment.appendChild(document.createElement('h1')),
            h3 = document.createElement('h3');

        assert.equal(insertAfter(h3, h1), h3);
    });
});