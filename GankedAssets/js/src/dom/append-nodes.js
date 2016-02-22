/**
 * (c) 2015 Ganked
 */

/**
 * @param {Node} parent
 * @param {Node} nodes
 */
export function appendNodes(parent, ...nodes) {
    nodes.forEach(node => parent.appendChild(node));
}