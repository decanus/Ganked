/**
 * (c) 2015 Ganked
 */

import { getLocalStorage } from '../std/storage/wrapper';
import { isComparing, addSummoner, removeSummoner, getSummonersWithData } from '../lol/comparison';
import { ActionButton } from './action-button';
import { document } from '../dom/document/document';
import { CoreElement } from './core';
import { createElement, text } from '../dom/create-element';
import { appendNodes } from '../dom/append-nodes';

/**
 *
 * @type {StorageWrapper}
 */
const localStorage = getLocalStorage();

/**
 * @param {HTMLDocument} $document
 * @param {number} summonerCount
 * @returns {DocumentFragment}
 */
function getPlaceholderMessage($document, summonerCount) {
    let $frag = $document.createDocumentFragment(), word = 'more', $p;

    if (summonerCount === 0) {
        word = 'some';
    }

    $frag.appendChild(createElement($document, 'p', {
        [text]: 'You need to add at least 2 summoners.'
    }));

    $p = $frag.appendChild(createElement($document, 'p'));

    $p.appendChild(createElement($document, 'a', {
        [text]: `Find ${word} summoners`,
        href: '/games/lol/search'
    }));

    return $frag;
}

class SummonerComparison extends CoreElement {
    attachedCallback() {
        document(this).addEventListener('lolComparisonUpdate', () => this.render());

        this.render();
    }

    render() {
        let summoners = getSummonersWithData(localStorage),
            $document = document(this);

        this.hidden = (summoners.length === 0);

        if (this.hidden) {
            return;
        }

        this.$summoners.innerHTML = '';

        let nodes = summoners.map(summoner => {
            let $div = createElement($document, 'div', {
                'class': 'summoner-box -no-background -block'
            });

            let $image = $div.appendChild(createElement($document, 'div', {'class': 'image'}));

            $image.appendChild(createElement($document, 'img', {
                'class': 'image',
                src: summoner.image
            }));

            let $text = $div.appendChild(createElement($document, 'span', {'class': 'content'}));

            $text.appendChild(createElement($document, 'a', {
                [text]: summoner.name,
                'class': 'title _block',
                'href': summoner.link
            }));

            let $link = createElement($document, 'a', {
                [text]: 'remove',
                'class': '_blue _small'
            });

            $text.appendChild($link);
            $link.addEventListener('click', () => {
                removeSummoner(localStorage, summoner.id);
                $document.dispatchEvent(new CustomEvent('lolComparisonUpdate'));
            });

            return $div;
        });

        let content;

        if (summoners.length < 2) {
            content = getPlaceholderMessage($document, summoners.length);
            this.$button.href = '';
        } else {
            content = createElement($document, 'p');
            content.appendChild(createElement($document, 'a', {
                [text]: 'Go to comparison',
                href: this.href
            }));

            this.$button.href = this.href;
        }

        nodes.push(content);

        appendNodes(this.$summoners, ...nodes);
    }

    /**
     *
     * @returns {Element}
     */
    get $summoners() {
        return this.querySelector(':scope > .dropdown > .content');
    }

    /**
     *
     * @returns {Element}
     */
    get $button() {
        return this.querySelector(':scope > .input > *');
    }

    /**
     *
     * @returns {string}
     */
    get href() {
        let query = getSummonersWithData(localStorage)
            .map(summoner => [summoner.key, summoner.region].map(encodeURIComponent).join(':'))
            .join(',');

        return `/games/lol/summoners/compare?summoners=${query}`;
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('summoner-comparison', SummonerComparison);
}