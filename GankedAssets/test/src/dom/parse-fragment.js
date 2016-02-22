/**
 * (c) 2015 Ganked
 */

import { parseFragment } from '../../../js/src/dom/parse-fragment';
import assert from 'assert';

describe('parseFragment()', () => {
    it('returns the corresponding element', () => {
        let $ = parseFragment('<foo-bar class="baz">foo</foo-bar>');

        assert($ instanceof HTMLElement);
        assert.equal($.textContent, 'foo');
        assert.equal($.getAttribute('class'), 'baz');
        assert.equal($.tagName.toLowerCase(), 'foo-bar');
    });
});