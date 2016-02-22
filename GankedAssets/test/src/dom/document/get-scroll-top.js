/**
 * (c) 2015 Ganked <ganked.net>
 */

import assert from 'assert';
import { getScrollTop } from '../../../../js/src/dom/document/get-scroll-top';

describe('getScrollTop()', () => {
    it('returns a number', () => {
        assert(typeof getScrollTop() === 'number');
    });
});