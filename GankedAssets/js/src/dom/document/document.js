/**
 * (c) 2015 Ganked
 */

/**
 *
 * @param {Node,NodeList} node
 * @returns {Document}
 * @deprecated
 * @use getDocumentOf()
 */
export function document(node) {
    if (node instanceof Document) {
        return node;
    }

    if (node instanceof NodeList) {
        return document(node[0]);
    }

    return node.ownerDocument;
}