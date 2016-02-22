/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

/**
 *
 * @returns {Promise<number>}
 */
export function getAnimationFrame() {
    return new Promise(resolve => {
        requestAnimationFrame(n => {
            resolve(n);
        });
    });
}