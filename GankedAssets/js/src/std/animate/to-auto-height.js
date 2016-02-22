/**
 * (c) 2015 Ganked <feedback@ganked.net>
 */

import { getAutoHeight } from '../dimensions/get-auto-height';

/**
 *
 * @param {Element} $
 * @returns {Promise}
 */
export function animateToAutoHeight($) {
    let height = getAutoHeight($),
        styles = getComputedStyle($),
        props = styles['transition-property'].split(',').map(s => s.trim());

    if (props.indexOf('height') === -1) {
        $.style.height = 'auto';

        return Promise.resolve($);
    }

    return new Promise(resolve => {
        let listener = () => {
            $.removeEventListener('transitionend', listener);
            $.style.height = 'auto';

            resolve($);
        };

        $.addEventListener('transitionend', listener);
        $.style.height = `${height}px`;
    });
}