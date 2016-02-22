/**
 * (c) 2015 Ganked
 */

/**
 *
 * @param {StorageWrapper} storage
 * @param {string} summonerId
 * @returns {boolean}
 */
export function isComparing(storage, summonerId) {
    return getSummoners(storage).indexOf(summonerId) > -1;
}

/**
 *
 * @param {StorageWrapper} storage
 * @param {string} summonerId
 * @param {{}} data
 */
export function addSummoner(storage, summonerId, data) {
    let summoners = getSummoners(storage);

    summoners.push(summonerId);
    storage.set('lol:comparision', summoners);
    storage.set(`lol:comparison:${summonerId}`, data);
}

/**
 *
 * @param {StorageWrapper} storage
 * @param {string} summonerId
 */
export function removeSummoner(storage, summonerId) {
    let summoners = getSummoners(storage);

    if (!isComparing(storage, summonerId)) {
        return;
    }

    summoners.splice(summoners.indexOf(summonerId), 1);
    storage.set('lol:comparision', summoners);
    storage.delete(`lol:comparison:${summonerId}`);
}

/**
 *
 * @param {StorageWrapper} storage
 * @returns {Array<string>}
 */
export function getSummoners(storage) {
    if (!storage.has('lol:comparision')) {
        return [];
    }

    return storage.get('lol:comparision');
}

/**
 *
 * @param {StorageWrapper} storage
 */
export function removeAllSummoners(storage) {
    return getSummoners(storage).forEach(id => removeSummoner(storage, id));
}

/**
 *
 * @param {StorageWrapper} storage
 * @returns {Array<{}>}
 */
export function getSummonersWithData(storage) {
    return getSummoners(storage).map(id => {
        return Object.assign({ id }, storage.get(`lol:comparison:${id}`));
    });
}