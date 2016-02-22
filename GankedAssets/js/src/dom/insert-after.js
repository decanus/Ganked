/**
 * (c) 2015 Ganked <ganked.net>
 */

/**
 *
 * @param {Node} newChild
 * @param {Node} refChild
 *
 * @returns {Node}
 */
export function insertAfter(newChild, refChild) {
    let parent = refChild.parentNode;

    if (parent.lastChild === refChild) {
        return parent.appendChild(newChild);
    }

    return parent.insertBefore(newChild, refChild.nextSibling);
}