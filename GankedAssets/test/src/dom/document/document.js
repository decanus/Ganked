/**
 * (c) 2015 Ganked
 */

import { document as getDocument } from '../../../../js/src/dom/document/document';
import assert from 'assert';

describe('document()', () => {
    it('returns the ownerDocument of a node', () => {
        let $ = document.createElement('div');

        assert.equal(getDocument($), $.ownerDocument);
    });

    it('returns the passed object if it is a document', () => {
        assert.equal(getDocument(document), document);
    });

    it('returns the first owner document for a list', () => {
        let $ = document.querySelector('*');

        assert.equal(getDocument($), document);
    });
});