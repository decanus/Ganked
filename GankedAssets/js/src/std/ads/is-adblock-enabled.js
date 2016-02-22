/**
 * (c) 2015 Ganked
 */

import { createElement } from '../../dom/create-element';

/**
 *
 * @returns {boolean}
 */
export function isAdblockEnabled() {
    let div, isEnabled;

    div = createElement(document, 'div', {
       'class': 'adsbygoogle'
    });

    document.body.appendChild(div);
    isEnabled = (getComputedStyle(div).display === 'none');
    document.body.removeChild(div);

    return isEnabled;
}