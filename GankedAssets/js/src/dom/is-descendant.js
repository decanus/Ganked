/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {Node} parent
 * @param {Node} child
 * @returns {boolean}
 */
export function isDescendant(parent, child) {
    let node = child.parentNode;

    if (parent === child) {
        return true;
    }

    while (node !== null) {
        if (node == parent) {
            return true;
        }

        node = node.parentNode;
    }

    return false;
}