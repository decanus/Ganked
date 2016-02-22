/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { onReady } from './dom/document/on-ready';
import { forEach } from './utils/for-each';

function updateElements() {
    let $elements = document.querySelectorAll('[data-effect]');

    forEach($elements, function ($elem) {
        let bounding = $elem.getBoundingClientRect();

        if (bounding.top < window.innerHeight && bounding.bottom > 0) {
            $elem.classList.add($elem.dataset.effect);
        }
    });
}

export default function () {
    onReady().then(function () {
        updateElements();
        window.addEventListener('scroll', updateElements);
    });
}