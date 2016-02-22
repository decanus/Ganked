/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

import { CoreElement } from './core';
import { forEach } from '../utils/for-each';
import { forOwn } from '../utils/for-own';
import { lookup } from '../utils/lookup';
import { padString } from '../string/pad-string';
import { getWorker } from '../std/worker/get-worker';
import { Promise } from 'es6-promise';

import Symbol from 'es6-symbol';

/**
 *
 * @type {Symbol}
 */
const timer = Symbol('timer');

/**
 *
 * @type {Symbol}
 */
const ticks = Symbol('ticks');

/**
 *
 * @type {string}
 */
const championKill = 'CHAMPION_KILL';

/**
 *
 * @type {string}
 */
const itemPurchased = 'ITEM_PURCHASED';

/**
 *
 * @type {Map}
 */
const storage = new Map();

/**
 *
 * @param {TimeLine} $timeline
 */
function registerActions($timeline) {
    $timeline
        .querySelector('[data-action="time-line:play"]')
        .addEventListener('click', () => $timeline.play());

    $timeline
        .querySelector('[data-action="time-line:pause"]')
        .addEventListener('click', () => $timeline.pause());

    $timeline
        .querySelector('[data-action="time-line:speedup"]')
        .addEventListener('click', () => $timeline.speedup());

    $timeline
        .querySelector('[data-action="time-line:slowdown"]')
        .addEventListener('click', () => $timeline.slowdown());

    let $scrubber = $timeline.querySelector('input[is=timeline-scrubber]');

    if ($scrubber) {
        $scrubber.setAttribute('max', $timeline.frames[$timeline.frames.length - 1].timestamp);
    }
}

/**
 *
 * @param {TimeLine} $timeline
 */
function showHideActions($timeline) {
    if ($timeline.playing) {
        $timeline.querySelector('[data-action="time-line:play"]').setAttribute('hidden', '');
        $timeline.querySelector('[data-action="time-line:pause"]').removeAttribute('hidden');
    } else {
        $timeline.querySelector('[data-action="time-line:play"]').removeAttribute('hidden');
        $timeline.querySelector('[data-action="time-line:pause"]').setAttribute('hidden', '');
    }
}

/**
 *
 * @param {TimeLine} timeline
 * @param {string} key
 * @returns {*}
 */
function getTimelineValue(timeline, key) {
    let ts = timeline[ticks];

    switch (key) {
    case 'speed':
        return timeline.speed + 'x';
    case 'time':
        return formatTimestamp(ts);
    case 'towers:blue':
        return storage.get(ts).towers[100];
    case 'towers:purple':
        return storage.get(ts).towers[200];
    case 'barons:blue':
        return storage.get(ts).barons[100];
    case 'barons:purple':
        return storage.get(ts).barons[200];
    case 'dragons:blue':
        return storage.get(ts).dragons[100];
    case 'dragons:purple':
        return storage.get(ts).dragons[200];
    default:
        return '';
    }
}

/**
 *
 * @param {TimeLine} $timeline
 * @param {string} key
 * @param {string} player
 */
function getPlayerTimelineValue($timeline, key, player) {
    let frame = $timeline.frames[$timeline.frame];

    if (key === 'kills') {
        return $timeline.events
            .filter(e =>  e.eventType === championKill && e.killerId == player)
            .map(() => 1)
            .reduce((a, b) => a + b, 0);
    }

    if (key === 'assists') {
        return $timeline.events
            .filter(e => {
                return e.eventType === championKill &&
                    e.assistingParticipantIds !== undefined &&
                    e.assistingParticipantIds.indexOf(Number(player)) > -1;
            })
            .map(() => 1)
            .reduce((a, b) => a + b, 0);
    }

    if (key === 'deaths') {
        return $timeline.events
            .filter(e => e.eventType === championKill && e.victimId == player)
            .map(() => 1)
            .reduce((a, b) => a + b, 0);
    }

    return lookup(frame.participantFrames[player], key);
}

/**
 *
 * @param {number} speed
 * @returns {number}
 */
function getSpeedup(speed) {
    if (speed === 1) {
        return 16;
    }

    if (speed < 128) {
        return speed * 2;
    }

    return 1;
}

/**
 *
 * @param {number} speed
 * @returns {number}
 */
function getSlowdown(speed) {
    if (speed === 1) {
        return 128;
    }

    if (speed > 16) {
        return speed / 2;
    }

    return 1;
}

/**
 *
 * @param {number} time
 * @returns {string}
 */
function formatTimestamp(time) {
    let minutes = Math.floor(time / 60000),
        seconds = Math.floor((time - minutes * 60000) / 1000);

    return padString(minutes, '0', 2, 'left') + ':' + padString(seconds, '0', 2, 'left');
}

class TimeLine extends CoreElement {
    /**
     * @internal
     */
    createdCallback() {
        /**
         *
         * @type {number}
         */
        this[ticks] = 0;

        let resources = [
            fetch(this.href),
            getWorker('//cdn.ganked.net/js/timeline-worker.js')
        ];

        Promise
            .all(resources)
            .then((resp) => Promise.all([resp[0].json(), resp[1]]))
            .then(resp => {
                let json = resp[0],
                    worker = resp[1];

                this.frames = json.frames;
                this.frameInterval = json.frameInterval;

                worker.postMessage({ frames: json.frames, players: json.participants });
                worker.addEventListener('message', (e) => {
                    let data = e.data;

                    storage.set(data.timestamp, data);
                });

                registerActions(this);
            });
    }

    /**
     *
     * @internal
     * @param {string} attr
     */
    attributeChangedCallback(attr) {
        if (attr === 'frame') {
            this.render();
        }
    }

    /**
     * Starts the playback
     * @api
     */
    play() {
        if (this.playing) {
            return;
        }

        this.tick();
        showHideActions(this);
    }

    /**
     * @internal
     */
    tick() {
        if (this[ticks] === 0) {
            forEach(this.querySelectorAll('timeline-item'), $item => $item.empty());
        }

        this.frame = Math.round(this[ticks] / 60000);

        this.render();

        if (storage.has(this[ticks])) {
            this[ticks] += 1000;
        }

        if (this[ticks] >= this.frames.slice(-1)[0].timestamp) {
            return this.reset();
        }

        this[timer] = setTimeout(() => this.tick(), 1000 / this.speed);
    }

    /**
     * @api
     */
    pause() {
        if (!this.playing) {
            return;
        }

        clearTimeout(this[timer]);
        this[timer] = 0;
        showHideActions(this);
    }

    /**
     * @api
     */
    reset() {
        this.pause();
        this[ticks] = 0;
    }

    /**
     * @api
     */
    speedup() {
        this.speed = getSpeedup(this.speed);
        this.play();
        this.render();
    }

    /**
     * @api
     */
    slowdown() {
        this.speed = getSlowdown(this.speed);
        this.play();
        this.render();
    }

    /**
     * @internal
     */
    render() {
        if (!this.frames) {
            return;
        }

        let $values = this.querySelectorAll('timeline-value');

        forEach($values, $value => {
            if ($value.hasAttribute('player')) {
                $value.value = getPlayerTimelineValue(this, $value.key, $value.player);
            } else {
                $value.value = getTimelineValue(this, $value.key);
            }
        });

        forEach(this.querySelectorAll('timeline-item'), $ => $.empty());

        forOwn(storage.get(this[ticks]).items, (items, player) => {
            let $slots = this.querySelectorAll(`timeline-item[player="${player}"]`);

            items.forEach((item, i) => {
                let $slot = $slots[i];

                if (!item) {
                    return;
                }

                if ($slot) {
                    $slot.src = item.image;
                    $slot.title = item.name;
                    $slot.description = item.description;
                    $slot.render(!this.playing);
                }
            });
        });

        let $scrubber = this.querySelector('input[is=timeline-scrubber]');

        if ($scrubber) {
            $scrubber.value = this[ticks];
        }
    }

    /**
     * @return {string}
     */
    get href() {
        return this.getAttribute('href');
    }

    /**
     *
     * @returns {number}
     */
    get speed() {
        return parseInt(this.getAttribute('speed')) || 1;
    }

    /**
     *
     * @param {number} multiplier
     */
    set speed(multiplier) {
        this.setAttribute('speed', multiplier);
    }

    /**
     *
     * @returns {Number}
     */
    get frame() {
        return parseInt(this.getAttribute('frame')) || 0;
    }

    /**
     *
     * @returns {boolean}
     */
    get playing() {
        return !!this[timer];
    }

    /**
     *
     * @param {Number} value
     */
    set frame(value) {
        this.setAttribute('frame', value.toString());
    }

    /**
     *
     * @param {number} value
     */
    set ticks(value) {
        this[ticks] = Math.ceil(value / 1000) * 1000;
        this.frame = Math.round(this[ticks] / 60000);
    }

    /**
     *
     * @returns {number}
     */
    get ticks() {
        return this[ticks];
    }

    /**
     *
     * @returns {Array<{}>}
     */
    get events() {
        return this.frames
            .map(frame => frame.events)
            .reduce((a, b) => [].concat(a, b))
            .filter(events => events !== undefined)
            .filter(e => this[ticks] >= e.timestamp);
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function timeLine(document) {
    document.registerElement('time-line', TimeLine);
}