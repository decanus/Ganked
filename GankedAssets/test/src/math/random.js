/**
 * (c) 2015 Ganked <ganked.net>
 */

import { getRandomNumber } from '../../../js/src/math/random';
import assert from 'assert';

describe('getRandomNumber()', () => {
    it('returns a number', () => {
        assert.equal(typeof getRandomNumber(1, 10), 'number');
        assert.equal(typeof getRandomNumber(1, 10), 'number');
        assert.equal(typeof getRandomNumber(1, 10), 'number');
        assert.equal(typeof getRandomNumber(1, 10), 'number');
    });
});