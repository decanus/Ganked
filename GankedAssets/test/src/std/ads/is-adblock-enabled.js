/**
 * (c) 2015 Ganked
 */

import { isAdblockEnabled } from '../../../../js/src/std/ads/is-adblock-enabled';
import assert from 'assert';

describe('isAdblockEnabled()', () => {
    it('returns true if the default styles for .adsbygoogle are display: none', () => {
        let styles = document.createElement('style');
        styles.innerHTML = '.adsbygoogle { display: none }';
        document.head.appendChild(styles);

        assert.equal(isAdblockEnabled(), true);

        document.head.removeChild(styles);
    });

    it('returns false if .adsbygoogle is visible', () => {
       assert.equal(isAdblockEnabled(), false);
    });
});