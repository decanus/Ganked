/**
 * (c) 2015 Ganked
 */

/**
 *
 * @param {{}} object
 * @param {string} path
 * @deprecated
 */
export function lookup(object, path) {
    let parts = path.split('.'),
        current = parts[0],
        rest = parts.slice(1);

    if (current === '__proto__') {
        throw new Error('illegal [proto] access');
    }

    if (rest.length > 0) {
        return lookup(object[current], rest.join('.'));
    }

    return object[current];
}