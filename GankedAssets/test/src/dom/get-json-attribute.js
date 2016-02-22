/**
 * (c) 2015 Ganked
 */

import { getJSONAttribute } from '../../../js/src/dom/get-json-attribute';
import assert from 'assert';

describe('getJSONAttribute()', () => {
    it('parses the attribute', () => {
        let $ = document.createElement('div');
        $.setAttribute('foo', JSON.stringify({ bar: 'baz' }));

        assert.deepEqual(getJSONAttribute($, 'foo'), { bar: 'baz' });
    });

    it('returns the default value if the value is not valid JSON', () => {
        let $ = document.createElement('div');
        $.setAttribute('foo', 'bar-baz');

        assert.equal(getJSONAttribute($, 'foo', 'bar'), 'bar');
    });
});