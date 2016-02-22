/**
 * (c) 2015 Ganked.net <feedback@ganked.net>
 */

import easteregg  from './easteregg.js';
import effects from './effects.js';
import page from './page.js';

// Custom Elements
import ajaxForm from './elements/ajax-form';
import fetchContent from './elements/fetch-content';
import infoBox from './elements/info-box';
import multiSearch from './elements/multi-search';
import steamSearch from './elements/steam-search';
import randomImage from './elements/random-image';
import searchSuggestions from './elements/search-suggestions';
import gnkdTab from './elements/gnkd-tab';
import tabLink from './elements/tab-link';
import pieChart from './elements/pie-chart';
import actionButton from './elements/action-button';
import compareButton from './elements/compare-button';
import compareClearButton from './elements/compare-clear-button';
import modalDialog from './elements/modal-dialog';
import timeLine from './elements/time-line';
import timelineValue from './elements/timeline-value';
import timelineItem from './elements/timeline-item';
import timelineScrubber from './elements/timeline-scrubber';
import summonerComparison from './elements/summoner-comparison';
import additionalContent from './elements/additional-content';
import additionalContentToggle from './elements/additional-content-toggle';

import twitchPlayer from './modules/TwitchPlayer.js';
import header from './modules/Header.js';
import slider from './modules/Slider.js';

easteregg(window);
effects();
page();

ajaxForm(document);
fetchContent(document);
infoBox(document);
multiSearch(document);
randomImage(document);
searchSuggestions(document);
gnkdTab(document);
tabLink(document);
pieChart(document);
actionButton(document);
compareButton(document);
compareClearButton(document);
modalDialog(document);
timeLine(document);
timelineValue(document);
timelineItem(document);
timelineScrubber(document);
steamSearch(document);
summonerComparison(document);
additionalContent(document);
additionalContentToggle(document);

twitchPlayer();
header('.page-banner', false, 'banner');
slider();