/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {Node} node
 * @returns {Node}
 */
export function removeNode(node) {
    let parent = node.parentNode;

    if (parent === null) {
        return node;
    }

    return parent.removeChild(node);
}
