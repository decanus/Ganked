/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

import { getAutoHeight } from '../dimensions/get-auto-height';
import { propertyHasTransition } from '../css/property-has-transition';
import { getTimeout } from '../../timers/get-timeout';

/**
 *
 * @param {Element} $
 * @returns {Promise}
 */
function waitForTransitionEnd($) {
    return new Promise(resolve => {
        let listener = () => {
            $.removeEventListener('transitionend', listener);
            resolve($);
        };

        $.addEventListener('transitionend', listener);
    });
}

/**
 *
 * @param {Element} $
 * @param {number} height
 * @returns {Promise}
 */
export function animateFromAutoHeight($, height = 0) {
    if (!propertyHasTransition($, 'height')) {
        $.style.height = `${height}px`;
        return Promise.resolve($);
    }

    $.style.height = `${getAutoHeight($)}px`;

    return getTimeout(40).then(() => {
        let end = waitForTransitionEnd($);

        $.style.height = `${height}px`;

        return end;
    });
}