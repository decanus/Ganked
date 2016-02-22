/**
 * (c) 2015 Ganked
 */

import { getClipboardData } from '../../../../js/src/dom/clipboard/get-clipboard-data';
import assert from 'assert';

describe('getClipboardData()', () => {
    it('returns the clipboard data', () => {
        let event = {
            clipboardData: {
                getData(mime) {
                    assert.equal(mime, 'text/plain');

                    return 'foobar';
                }
            }
        };

        assert.equal(getClipboardData(event), 'foobar');
    });
});