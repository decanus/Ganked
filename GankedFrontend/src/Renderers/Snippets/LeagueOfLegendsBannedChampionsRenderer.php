<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;
    use Ganked\Library\Helpers\DomHelper;

    class LeagueOfLegendsBannedChampionsRenderer
    {
        /**
         * @var LeagueOfLegendsChampionTooltipRenderer
         */
        private $leagueOfLegendsChampionTooltipRenderer;

        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $leagueOfLegendsDataPoolReader;

        /**
         * @param LeagueOfLegendsChampionTooltipRenderer $leagueOfLegendsChampionTooltipRenderer
         * @param LeagueOfLegendsDataPoolReader          $leagueOfLegendsDataPoolReader
         */
        public function __construct(
            LeagueOfLegendsChampionTooltipRenderer $leagueOfLegendsChampionTooltipRenderer,
            LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader
        )
        {
            $this->leagueOfLegendsChampionTooltipRenderer = $leagueOfLegendsChampionTooltipRenderer;
            $this->leagueOfLegendsDataPoolReader = $leagueOfLegendsDataPoolReader;
        }

        /**
         * @param array $banned
         * @param int   $teamId
         *
         * @return DomHelper
         */
        public function render(array $banned, $teamId)
        {
            $dom = new DomHelper('<div class="item -center"/>');
            $grid = $dom->firstChild->appendChild($dom->createElement('div'));
            $grid->setAttribute('class', 'grid-wrapper -gap');
            $hasBanned = false;

            $labelWrap = $dom->createElement('div');
            $labelWrap->setAttribute('class', 'item -center');
            $labelWrap->appendChild($dom->createElement('small', 'Banned'));

            if ($teamId === 100) {
                $grid->appendChild($labelWrap);
            }

            foreach ($banned as $champion) {
                if ($champion['teamId'] !== $teamId) {
                    continue;
                }

                $hasBanned = true;

                $championDom = $this->leagueOfLegendsChampionTooltipRenderer->render(
                    $this->leagueOfLegendsDataPoolReader->getChampionDataById($champion['championId'])
                );

                $championDom->getFirstElementByTagName('a')
                    ->setAttribute('class', 'avatar-box -match-overview');

                $dom->importAndAppendChild($grid, $championDom->firstChild);
            }

            if ($teamId === 200) {
                $grid->appendChild($labelWrap);
            }

            if (!$hasBanned) {
                $dom->firstChild->removeChild($grid);
            }

            return $dom;
        }
    }
}
