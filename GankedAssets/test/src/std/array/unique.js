/**
 * (c) 2015 Ganked
 */

import { unique } from '../../../../js/src/std/array/unique';
import assert from 'assert';

describe('unique()', () => {
    it('returns a unique list', () => {
        let obj = {},
            arr = [obj, 'foo', 'bar', 'foo', obj, 'baz', 1, 2, 3, 4, 1];

        assert.deepEqual(unique(arr), [obj, 'foo', 'bar', 'baz', 1, 2, 3, 4]);
    });
});