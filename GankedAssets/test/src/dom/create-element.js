/**
 * (c) 2015 Ganked
 */

import { createElement, text } from '../../../js/src/dom/create-element';
import assert from 'assert';

describe('createElement()', () => {
    it('returns an element of given type', () => {
        let $ = createElement(document, 'a');

        assert($ instanceof HTMLElement);
        assert.equal($.tagName.toLowerCase(), 'a');
    });

    it('accepts text content', () => {
        let $ = createElement(document, 'span', {
            [text]: 'foobar'
        });

        assert.equal($.innerHTML, 'foobar');
    });

    it('sets given attributes', () => {
        let $ = createElement(document, 'span', {
            foo: 'bar',
            baz: 'foobar'
        });

        assert.equal($.getAttribute('foo'), 'bar');
        assert.equal($.getAttribute('baz'), 'foobar');
    });
});