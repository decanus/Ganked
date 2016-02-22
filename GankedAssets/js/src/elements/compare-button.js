/**
 * (c) 2015 Ganked
 */

import { getLocalStorage } from '../std/storage/wrapper';
import { isComparing, addSummoner, removeSummoner, getSummonersWithData } from '../lol/comparison';
import { ActionButton } from './action-button';
import { document } from '../dom/document/document';
import { getJSONAttribute } from '../dom/get-json-attribute';

/**
 *
 * @type {StorageWrapper}
 */
const localStorage = getLocalStorage();

class CompareButton extends ActionButton {
    attachedCallback() {
        this.addEventListener('click', () => {
            let active = !this.active;

            if (active) {
                addSummoner(localStorage, this.summonerId, this.summonerInfo);
            } else {
                removeSummoner(localStorage, this.summonerId);
            }

            document(this).dispatchEvent(new CustomEvent('lolComparisonUpdate'));

            this.active = active;
        });

        document(this).addEventListener('lolComparisonUpdate', () => this.render());

        this.render();
    }

    render() {
        /**
         *
         * @type {boolean}
         */
        this.active = isComparing(localStorage, this.summonerId);
    }

    /**
     *
     * @returns {string}
     */
    get summonerId() {
        return this.getAttribute('summoner-id');
    }

    /**
     *
     * @returns {{}}
     */
    get summonerInfo() {
        return getJSONAttribute(this, 'summoner-info');
    }
}

/**
 *
 * @param {HTMLDocument} document
 */
export default function (document) {
    document.registerElement('compare-button', {
        prototype: CompareButton.prototype,
        'extends': 'button'
    });
}