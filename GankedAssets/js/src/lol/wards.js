/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 *     You may not copy ANY portion of this code WITHOUT WRITTEN PERMISSION
 *     of Ganked. If you do so, my ghost will haunt you until the end of your
 *     MISERABLE LIFE.
 */

const wards = {
    SIGHT_WARD: 2044,
    TEEMO_MUSHROOM: null,
    UNDEFINED: null,
    VISION_WARD: 2043,
    YELLOW_TRINKET: null,
    YELLOW_TRINKET_UPGRADE: null
};

/**
 *
 * @param {string} ward
 * @returns {number}
 */
export function getItemIdForWard(ward) {
    return wards[ward];
}