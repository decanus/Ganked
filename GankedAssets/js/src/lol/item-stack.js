/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 *     You may not copy ANY portion of this code WITHOUT WRITTEN PERMISSION
 *     of Ganked. If you do so, my ghost will haunt you until the end of your
 *     MISERABLE LIFE.
 */

export class ItemStack {
    constructor() {
        /**
         *
         * @type {Array}
         */
        this.items = Array.from({ length: 7 });

        /**
         *
         * @type {Array}
         */
        this.stacks = Array.from({ length: 7 });

        /**
         *
         * @type {{}}
         */
        this.itemIds = {};
    }

    /**
     *
     * @param {number} itemId
     * @param {{ stacks: number }} item
     */
    add(itemId, item) {
        let indexes = this.itemIds[itemId];

        if (indexes) {
            for (let i = 0; i < indexes.length; i++) {
                let stack = this.stacks[indexes[i]];

                if (stack < item.stacks && item.stacks > 1) {
                    return item.stacks++;
                }
            }
        }

        let freeSlot = this.items.indexOf(undefined);

        if (freeSlot === -1) {
            freeSlot = this.items.length;
        }

        if (!indexes) {
            this.itemIds[itemId] = [freeSlot];
        } else {
            this.itemIds[itemId].push(freeSlot);
        }

        this.items[freeSlot] = item;
        this.stacks[freeSlot] = 1;
    }

    /**
     *
     * @param {string} itemId
     */
    remove(itemId) {
        if (!this.itemIds[itemId]) {
            return;
        }

        let lastIndex = this.itemIds[itemId].slice(-1)[0],
            stack = this.stacks[lastIndex];

        if (stack > 1) {
            return this.stacks[lastIndex]--;
        }

        this.items[lastIndex] = undefined;
        this.stacks[lastIndex] = undefined;
        this.itemIds[itemId].pop();
    }

    /**
     *
     * @param {string} itemId
     */
    removeAll(itemId) {
        while(this.itemIds[itemId] && this.itemIds[itemId].length > 0) {
            this.remove(itemId);
        }
    }

    /**
     *
     * @returns {Array}
     */
    getAll() {
        return this.items;
    }
}