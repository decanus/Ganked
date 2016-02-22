/**
 * (c) 2015 Ganked
 */

import assert from 'assert';
import { Promise } from 'es6-promise';
import { onReady } from '../../../../js/src/dom/document/on-ready';

describe('onReady()', () => {
    it('returns a promise', () => {
       assert(onReady() instanceof Promise);
    });

    it('resolves if the DOM is already loaded', (done) => {
        onReady({ readyState: 'complete' }).then(() => {
            done();
        });
    });

    it('contains a document', (done) => {
       onReady().then((doc) => {
           assert(doc instanceof Document);
           done();
       });
    });

    it('registers an event listener', (done) => {
        let doc = {
            addEventListener(type, callbackFn) {
                assert.equal(type, 'DOMContentLoaded');
                callbackFn();
            }
        };

        onReady(doc).then(() => {
            done();
        })
    });
});