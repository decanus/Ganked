/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { forEach } from '../utils/for-each';
import { getRandomNumber } from '../math/random';
import { CoreElement } from './core';

class RandomImage extends CoreElement {
    createdCallback() {
        let $images = this.querySelectorAll('img'),
            rand = getRandomNumber(1, $images.length) - 1;

        forEach($images, ($image, i) => {
            if (i === rand) {
                $image.removeAttribute('hidden');
            } else {
                $image.parentNode.removeChild($image);
            }
        });
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('random-image', RandomImage);
}