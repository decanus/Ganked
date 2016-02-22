/**
 * (c) 2015 Ganked
 */

/**
 *
 * @param {Node,NodeList} node
 * @returns {Document}
 */
export function getDocumentOf(node) {
    if (node instanceof Document) {
        return node;
    }

    if (node instanceof NodeList) {
        return getDocumentOf(node[0]);
    }

    return node.ownerDocument;
}