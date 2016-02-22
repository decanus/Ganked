<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Generators\ImageUriGenerator;
    use Ganked\Library\Generators\UriGenerator;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;

    class SummonerSnippetRenderer
    {
        /**
         * @var UriGenerator
         */
        private $uriGenerator;

        /**
         * @var ImageUriGenerator
         */
        private $imageUriGenerator;

        /**
         * @param UriGenerator      $uriGenerator
         * @param ImageUriGenerator $imageUriGenerator
         */
        public function __construct(UriGenerator $uriGenerator, ImageUriGenerator $imageUriGenerator)
        {
            $this->uriGenerator = $uriGenerator;
            $this->imageUriGenerator = $imageUriGenerator;
        }

        /**
         * @param array $summoner
         *
         * @return DomHelper
         */
        public function render(array $summoner)
        {
            $item = new DomHelper('<div class="item" />');

            $summonerBox = $item->createElement('a');
            $summonerBox->setAttribute('href', $this->uriGenerator->createSummonerUri(new Region($summoner['region']), new SummonerName($summoner['name'])));
            $summonerBox->setAttribute('class', 'summoner-box -block');
            $item->firstChild->appendChild($summonerBox);

            $imageBox = $item->createElement('div');
            $imageBox->setAttribute('class', 'image');
            $summonerBox->appendChild($imageBox);

            $image = $item->createElement('img');
            $image->setAttribute('src', $this->imageUriGenerator->createSummonerProfileIconUri($summoner['profileIconId']));
            $image->setAttribute('class', 'image');
            $image->setAttribute('alt', $summoner['name']);
            $imageBox->appendChild($image);

            $content = $item->createElement('aside');
            $content->setAttribute('class', 'content');
            $summonerBox->appendChild($content);

            $title = $item->createElement('h4', $summoner['name']);
            $title->setAttribute('class', 'title');
            $content->appendChild($title);

            $info = $item->createElement('div');
            $info->setAttribute('class', 'info');
            $content->appendChild($info);

            $region = $item->createElement('div', strtoupper($summoner['region']));
            $region->setAttribute('class', 'region _blue');
            $info->appendChild($region);

            $level = $item->createElement('div', 'Level ');
            $level->setAttribute('class', 'level');
            $levelText = $item->createElement('span', $summoner['summonerLevel']);
            $levelText->setAttribute('class', '_blue');
            $level->appendChild($levelText);
            $info->appendChild($level);

            return $item;
        }
    }
}
