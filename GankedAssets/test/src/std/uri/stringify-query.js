/**
 * (c) 2015 Ganked
 */

import { stringifyQuery } from '../../../../js/src/std/uri/stringify-query';
import assert from 'assert';

describe('stringifyQuery()', () => {
    it('returns a string representation', () => {
       assert.equal(stringifyQuery({ foo: 10, bar: 'baz' }), 'foo=10&bar=baz');
    });

    it('encodes keys and values', () => {
       assert.equal(stringifyQuery({ 'foo bar': 'baz&' }), 'foo%20bar=baz%26');
    });
});