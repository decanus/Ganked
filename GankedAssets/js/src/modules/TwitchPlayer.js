/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import { stringifyQuery } from '../std/uri/stringify-query';
import { onReady } from '../dom/document/on-ready';
import { parseFragment } from '../dom/parse-fragment';
import { Slider } from './Slider.js';

export class TwitchPlayer {
    /**
     *
     * @param {Element} $target
     * @param {Element} $list
     * @param {Element} $slider
     */
    constructor($target, $list, $slider) {
        /**
         *
         * @type {Element}
         */
        this.$ = $target;

        /**
         *
         * @type {Element}
         */
        this.$video = $target.querySelector(':scope > .video');

        /**
         *
         * @type {Element}
         */
        this.$list = $list;

        /**
         *
         * @type {Element}
         */
        this.$slider = $slider;

        /**
         *
         * @type {boolean}
         */
        this.playing = false;

        /**
         *
         * @type {boolean}
         * @private
         */
        this._hasStreams = false;

        /**
         *
         * @type {string}
         */
        this.src = '';
    }

    /**
     * @return {boolean}
     */
    isPlaying() {
        return this.playing;
    }

    play() {
        this.playing = true;

        // Update DOM
        this.$video.src = this.src;
        this.$.classList.add('-playing');
    }

    /**
     *
     * @param {boolean} hasStreams
     */
    setHasStreams(hasStreams) {
        this._hasStreams = hasStreams;

        // Update DOM
        this.$.classList[hasStreams ? 'remove' : 'add']('-noStreams');
    }

    /**
     *
     * @returns {boolean}
     */
    hasStreams() {
        return this._hasStreams;
    }

    /**
     *
     * @param {string} src
     */
    setSource(src) {
        if (this.isPlaying()) {
            this.$video.src = src;
        } else {
            this.src = src;
        }
    }

    /**
     * Fetches the streams and updates the player interface.
     */
    update() {
        var game = stringifyQuery({ game: this.$.dataset.game});

        this.reset();
        this.$.classList.add('-loading');

        fetch(`${this.$.getAttribute('href')}?${game}`).then(function (resp) {
            return resp.json();
        }).then((data) => {
            var streams = data.streams;

            this.reset();
            this.setHasStreams(streams !== null);

            if (this.hasStreams()) {
                var first = streams.shift();

                this.setCover(first.banner);
                this.setSource(first.src);
                this.setStreams(streams);
            }
        });
    }

    reset() {
        this.$list.innerHTML = '';
        this.$.classList.remove('-loading');
    }

    /**
     *
     * @param {string} cover
     */
    setCover(cover) {
        this.$.style.backgroundImage = 'url(' + cover + ')';
    }

    /**
     *
     * @param {Array} streams
     */
    setStreams(streams) {

        streams.forEach((stream) => {
            var preview = stream.preview, displayName = stream.display_name;

            var $stream = parseFragment(
                `<li class="stream"><img src="${preview}" alt="${displayName}"/></li>`
            );

            $stream.addEventListener('click',() => {
                this.setSource(stream.src);
                this.play();
            });

            this.$list.appendChild($stream);
        });

        this.slider = new Slider(this.$slider, {
            innerSelector: ':scope > .twitch-stream-list',
            itemSelector: ':scope > .twitch-stream-list > .stream'
        });
    }
}

export default function() {
    onReady().then(function(){
        var $player = document.querySelector('.twitch-player'),
            $list = document.querySelector('.twitch-stream-list'),
            $slider = document.querySelector('.twitch-streams');

        if ($player !== null && $list !== null) {
            var player = new TwitchPlayer($player, $list, $slider);

            var $play = player.$.querySelector(':scope > .playButton'),
                $reload = player.$.querySelector(':scope > .noStreams > .reload');

            $play.addEventListener('click', function () {
                player.play();
            });

            $reload.addEventListener('click', function () {
                player.update();
            });

            player.update();
        }
    });
}