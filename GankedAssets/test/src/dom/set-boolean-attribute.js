/**
 * (c) 2015 Ganked
 */

import { setBooleanAttribute } from '../../../js/src/dom/set-boolean-attribute';
import assert from 'assert';

describe('setBooleanAttribute()', () => {
    it('removes the attribute if the value is falsy', () => {
        let $ = document.createElement('foo-bar');
        $.setAttribute('baz', '');

        setBooleanAttribute($, 'baz', false);

        assert.equal($.hasAttribute('baz'), false);
    });

    it('adds the attribute if the value is truthy', () => {
        let $ = document.createElement('foo-bar');

        setBooleanAttribute($, 'baz', true);

        assert.equal($.hasAttribute('baz'), true);
    });
});