<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;

    class LeagueOfLegendsChampionTooltipRenderer
    {
        /**
         * @param array $champion
         *
         * @return DomHelper
         */
        public function render(array $champion = [])
        {
            $dom = new DomHelper('<div class="item -center"/>');

            $link = $dom->createElement('a');
            $link->setAttribute('class', 'avatar-box -match');
            $link->setAttribute('data-info-box', 'info-box');
            $link->setAttribute('href', '/games/lol/champions/' . strtolower($champion['key']));
            $dom->getFirstElementByTagName('div')->appendChild($link);

            $image = $dom->createElement('img');
            $image->setAttribute('class', 'image');
            $image->setAttribute('alt', $champion['name']);
            $image->setAttribute('src', '//cdn.ganked.net/images/lol/champion/icon/' . $champion['image']['full']);
            $link->appendChild($image);

            $infoBox = $dom->createElement('info-box');
            $infoBox->setAttribute('hidden', '');
            $dom->getFirstElementByTagName('div')->appendChild($infoBox);

            $name = $dom->createElement('h3', $champion['name']);
            $name->setAttribute('class', '_noMargin');
            $infoBox->appendChild($name);

            $title = $dom->createElement('p', ucfirst($champion['title']));
            $title->setAttribute('class', '_noMargin');
            $infoBox->appendChild($title);

            return $dom;
        }
    }
}
