/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { onReady } from './dom/document/on-ready';
import { forEach } from './utils/for-each';
import { isDescendant } from './dom/is-descendant';
import { isAdblockEnabled } from './std/ads/is-adblock-enabled';

export default function () {
    //
    // Based on the answer from
    // http://stackoverflow.com/questions/15738259/disabling-chrome-autofill#answer-26931180
    //
    if (/Chrome/.test(window.navigator.appVersion)) {
        onReady().then(function () {
            let $inputs = document.querySelectorAll('input[autocomplete=off]');

            forEach($inputs, function ($input) {
                $input.setAttribute('readonly', 'readonly');

                $input.addEventListener('focus', function listener() {
                    $input.removeAttribute('readonly');
                    $input.removeEventListener('focus', listener);
                });
            });
        });
    }

    onReady().then(() => {
        if (isAdblockEnabled()) {
            document.body.classList.add('-no-ads');
        }
    });

    onReady().then(function () {
        let $dropdown = document.querySelector('.user-dropdown');

        if ($dropdown) {
            let $inner = $dropdown.querySelector(':scope > .dropdown');

            $dropdown.querySelector(':scope > .avatar').addEventListener('click', () => {
                if ($inner.hasAttribute('hidden')) {
                    $inner.removeAttribute('hidden');
                    return;
                }

                $inner.setAttribute('hidden', '');
            });

            document.addEventListener('click', (e) => {
                if (e.target !== $dropdown && !isDescendant($dropdown, e.target)) {
                    $inner.setAttribute('hidden', '');
                }
            });
        }
    });
}