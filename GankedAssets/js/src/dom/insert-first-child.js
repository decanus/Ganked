/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {Node} child
 * @param {Node} parent
 * @returns {Node}
 */
export function insertFirstChild(child, parent) {
    let firstChild = parent.firstChild;

    if (firstChild) {
        return parent.insertBefore(child, firstChild);
    }

    return parent.appendChild(child);
}
