<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Models\SummonerChampionsPageModel;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;
    use Ganked\Library\Generators\ImageUriGenerator;
    use Ganked\Library\Generators\UriGenerator;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\KDA;
    use Ganked\Library\ValueObjects\StatisticNumber;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class SummonerChampionsPageRenderer extends AbstractSummonerPageRenderer
    {
        /**
         * @var ImageUriGenerator
         */
        private $imageUriGenerator;

        /**
         * @param DomBackend                       $domBackend
         * @param DomHelper                        $template
         * @param SnippetTransformation            $snippetTransformation
         * @param TextTransformation               $textTransformation
         * @param GenericPageRenderer              $genericPageRenderer
         * @param SummonerSidebarRenderer          $summonerSidebarRenderer
         * @param LeagueOfLegendsDataPoolReader    $leagueOfLegendsDataPoolReader
         * @param LeagueOfLegendsSearchBarRenderer $searchBarRenderer
         * @param UriGenerator                     $uriBuilder
         * @param ImageUriGenerator                $imageUriGenerator
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer,
            SummonerSidebarRenderer $summonerSidebarRenderer,
            LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader,
            LeagueOfLegendsSearchBarRenderer $searchBarRenderer,
            UriGenerator $uriBuilder,
            ImageUriGenerator $imageUriGenerator
        )
        {
            parent::__construct(
                $domBackend,
                $template,
                $snippetTransformation,
                $textTransformation,
                $genericPageRenderer,
                $summonerSidebarRenderer,
                $leagueOfLegendsDataPoolReader,
                $searchBarRenderer,
                $uriBuilder
            );
            $this->imageUriGenerator = $imageUriGenerator;
        }

        /**
         * @return DomHelper
         */
        protected function renderContent()
        {
            $dom = new DomHelper('<div />');

            /**
             * @var $model SummonerChampionsPageModel
             */
            $model = $this->getModel();
            $stats = $model->getStats();

            if (empty($stats)) {
                $box = $dom->firstChild->appendChild(
                    $dom->createElement('div', 'No champion statistics were found.')
                );

                $box->setAttribute('class', 'generic-box -fit');

                return $dom;
            }

            $dom->firstChild->setAttribute('class', 'champion-table');

            $header = $dom->createElement('header');
            $header->setAttribute('class', 'header');

            $champion = $dom->createElement('div', 'Champion');
            $champion->setAttribute('class', 'name');
            $header->appendChild($champion);

            $matches = $dom->createElement('div', 'Matches');
            $matches->setAttribute('class', 'matches');
            $header->appendChild($matches);

            $winsLosses = $dom->createElement('div', 'W/L');
            $winsLosses->setAttribute('class', 'score');
            $header->appendChild($winsLosses);

            $kda = $dom->createElement('div', 'KDA');
            $kda->setAttribute('class', 'kda');
            $header->appendChild($kda);

            $cs = $dom->createElement('div', 'CS');
            $cs->setAttribute('class', 'cs');
            $header->appendChild($cs);

            $gold = $dom->createElement('div', 'Gold');
            $gold->setAttribute('class', 'gold');
            $header->appendChild($gold);

            $dom->firstChild->appendChild($header);

            foreach ($stats as $stat) {
                $championRow = $dom->createElement('div');
                $championRow->setAttribute('class', 'champion');

                $image = $dom->createElement('div');
                $image->setAttribute('class', 'image');

                $avatarBox = $dom->createElement('div');
                $avatarBox->setAttribute('class', 'avatar-box -summoner');

                $imageElement = $dom->createElement('img');
                $imageElement->setAttribute('class', 'image');
                $imageElement->setAttribute('src', $this->imageUriGenerator->createChampionIconUri($stat['champion']['key']));
                $avatarBox->appendChild($imageElement);

                $image->appendChild($avatarBox);

                $championRow->appendChild($image);

                $name = $dom->createElement('div', $stat['champion']['name']);
                $name->setAttribute('class', 'name');
                $championRow->appendChild($name);

                $sessionsPlayed = $stat['stats']['totalSessionsPlayed'];
                $matchesPlayed = $dom->createElement('div', $sessionsPlayed);
                $matchesPlayed->setAttribute('class', 'matches');
                $championRow->appendChild($matchesPlayed);

                $score = $dom->createElement('div', $stat['stats']['totalSessionsWon'] . ' / ' . $stat['stats']['totalSessionsLost']);
                $score->setAttribute('class', 'score');
                $championRow->appendChild($score);

                $kda = $dom->createElement(
                    'div',
                    new KDA($stat['stats']['totalChampionKills'], $stat['stats']['totalDeathsPerSession'], $stat['stats']['totalAssists'])
                );

                $kda->setAttribute('class', 'kda');
                $championRow->appendChild($kda);

                $cs = $dom->createElement('div', $stat['stats']['totalMinionKills']);
                $cs->setAttribute('class', 'cs');
                $championRow->appendChild($cs);

                $gold = $dom->createElement('div', (new StatisticNumber($stat['stats']['totalGoldEarned']))->getRounded());
                $gold->setAttribute('class', 'gold');
                $championRow->appendChild($gold);

                $dom->firstChild->appendChild($championRow);
            }

            return $dom;
        }

        /**
         * @return string
         */
        protected function getTitle()
        {
            return 'Champions';
        }

        /**
         * @return int
         */
        protected function getActiveNavItem()
        {
            return 4;
        }
    }
}
