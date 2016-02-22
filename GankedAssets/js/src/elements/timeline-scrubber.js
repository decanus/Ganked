/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

import { findClosestParent } from '../dom/find-closest-parent';

class TimelineScrubber {
    /**
     *
     * @internal
     */
    createdCallback() {
        this.setAttribute('min', 0);
        this.setAttribute('step', 1000);
        this.setAttribute('value', 0);

        this.addEventListener('input', () => {
            /**
             * @type {TimeLine}
             */
            let $timeline = findClosestParent(this, 'time-line');

            $timeline.pause();
            $timeline.ticks = this.value;
            $timeline.render();
        });
    }

    /**
     *
     * @internal
     */
    render() {

    }

    /**
     *
     * @param {string} value
     */
    set max(value) {
        this.setAttribute('max', value);
    }

    /**
     *
     * @returns {string}
     */
    get max() {
        return this.getAttribute('max');
    }
}

Object.setPrototypeOf(TimelineScrubber.prototype, HTMLInputElement.prototype);

/**
 *
 * @param {HTMLDocument} document
 */
export default function timelineScrubber(document) {
    document.registerElement('timeline-scrubber', {
        prototype: TimelineScrubber.prototype,
        'extends': 'input'
    });
}