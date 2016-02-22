<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Generators\ImageUriGenerator;
    use Ganked\Library\Helpers\DomHelper;

    class LeagueOfLegendsRunesSnippetRenderer
    {
        /**
         * @var ImageUriGenerator
         */
        private $uriGenerator;

        /**
         * @param ImageUriGenerator $uriGenerator
         */
        public function __construct(ImageUriGenerator $uriGenerator)
        {
            $this->uriGenerator = $uriGenerator;
        }

        /**
         * @param array $runes
         * @param string $title
         *
         * @return DomHelper
         */
        public function render(array $runes, $title = '')
        {
            $dom = new DomHelper('<div class="generic-box -no-margin"></div>');

            if ($title !== '') {
                $dom->appendChild($dom->createElement('h3'))->appendChild($dom->createTextNode($title));
            }

            $list = $dom->firstChild->appendChild($dom->createElement('ul'));
            $list->setAttribute('class', 'generic-list');

            foreach($runes as $rune) {
                $runeData = $rune['data'];
                $listItem = $list->appendChild($dom->createElement('li'));

                $grid = $listItem->appendChild($dom->createElement('div'));
                $grid->setAttribute('class', 'grid-wrapper -larger-gap');

                $imageWrap = $grid->appendChild($dom->createElement('div'));
                $imageWrap->setAttribute('class', 'item -center');

                $image = $imageWrap->appendChild($dom->createElement('img'));
                $image->setAttribute('class', 'rune-image');
                $image->setAttribute('alt', $runeData['name']);
                $image->setAttribute('src', $this->uriGenerator->createLeagueOfLegendsRuneIconUri($runeData['image']['full']));

                $count = $grid->appendChild($dom->createElement('div', $rune['count'] . 'x'));
                $count->setAttribute('class', 'item -center');

                $nameWrap = $grid->appendChild($dom->createElement('div'));
                $nameWrap->setAttribute('class', 'item -center');

                $name = $nameWrap->appendChild($dom->createElement('p', $runeData['name']));
                $name->setAttribute('class', '_noMargin');

                $description = $nameWrap->appendChild($dom->createElement('small', $runeData['sanitizedDescription']));
                $description->setAttribute('class', '_dim');
            }

            return $dom;
        }
    }
}
