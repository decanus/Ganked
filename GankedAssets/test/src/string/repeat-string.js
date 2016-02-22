/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

import { repeatString } from '../../../js/src/string/repeat-string';
import assert from 'assert';

describe('repeatString()', () => {
    it('repeats the string n times', () => {
        assert.equal(repeatString('a', 3), 'aaa');
        assert.equal(repeatString('a', 1), 'a');
    });
});