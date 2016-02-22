/**
 * (c) 2015 Ganked
 */

import { ItemStack } from '../lol/item-stack';
import { getItemIdForWard } from '../lol/wards';

/**
 *
 * @param {Array} events
 * @returns {{}}
 */
function getItemsFromEvents(events) {
    let playerItems = {};

    events
        .forEach(e => {
            if (e.participantId === 0) {
                return;
            }

            let id = e.participantId;

            if (e.eventType === 'WARD_PLACED') {
                id = e.creatorId;
            }

            if (id && playerItems[id] === undefined) {
                playerItems[id] = new ItemStack();
            }

            let itemStack = playerItems[id];

            if (e.eventType === 'ITEM_PURCHASED') {
                e.item.from.forEach(id => itemStack.remove(Number(id)));

                itemStack.add(e.itemId, e.item);
            }

            if (e.eventType === 'ITEM_SOLD') {
                itemStack.remove(e.itemId);
            }

            if (e.eventType === 'ITEM_DESTROYED') {
                itemStack.removeAll(e.itemId);
            }

            if (e.eventType === 'ITEM_UNDO') {
                itemStack.remove(e.itemBefore);

                if(e.itemAfter) {
                    itemStack.add(e.itemAfterId, e.itemAfter);
                }
            }

            /*if (e.eventType === 'WARD_PLACED') {
                let wardId = getItemIdForWard(e.wardType);

                if (wardId) {
                    itemStack.remove(wardId);
                }
            }*/
        });

    for(let key in playerItems) {
        playerItems[key] = playerItems[key].getAll();
    }

    return playerItems;
}

/**
 *
 * @param {Array} events
 * @returns {{100: number, 200: number}}
 */
function getTowersForEvents(events) {
    let teams = { 100: 0, 200: 0 };

    events
        .filter(e => e.eventType === 'BUILDING_KILL' && e.buildingType === 'TOWER_BUILDING')
        .forEach(e => {
            switch(e.teamId) {
            case 100:
                return teams[200]++;
            case 200:
                return teams[100]++;
            }
        });

    return teams;
}

/**
 *
 * @param {Array} events
 * @param {{}} players
 * @param {string} monster
 * @returns {{100: number, 200: number}}
 */
function getEliteMonsterKills(events, players, monster) {
    let teams = { 100: 0, 200: 0 };

    events
        .filter(e => e.eventType === 'ELITE_MONSTER_KILL' && e.monsterType === monster)
        .forEach(e => {
            let killer = e.killerId;

            teams[players[killer]]++;
        });

    return teams;
}

/**
 *
 * @param {Array<{}>} frames
 * @param {Number} timestamp
 * @returns {Array}
 */
function getEvents(frames, timestamp) {
    return frames
        .map(frame => frame.events)
        .filter(events => events !== undefined)
        .reduce((a, b) => [].concat(a, b))
        .filter(e => e.timestamp <= timestamp);
}

self.onmessage = function (e) {
    /**
     * @type {{ frames: Array<{}>, players: {} }}
     */
    let data = e.data,
        frames = data.frames,
        players = data.players;

    let i = 0,
        lastTimestamp = frames[frames.length - 1].timestamp;

    while(i <= lastTimestamp) {
        let events = getEvents(frames, i);

        self.postMessage({
            items: getItemsFromEvents(events),
            towers: getTowersForEvents(events),
            barons: getEliteMonsterKills(events, players, 'BARON_NASHOR'),
            dragons: getEliteMonsterKills(events, players, 'DRAGON'),
            timestamp: i
        });

        i += 1000;
    }

    self.close();
};