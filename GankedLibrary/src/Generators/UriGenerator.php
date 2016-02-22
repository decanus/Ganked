<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\Generators
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;

    class UriGenerator
    {
        /**
         * @param Region       $region
         * @param SummonerName $summonerName
         *
         * @return string
         */
        public function createSummonerUri(Region $region, SummonerName $summonerName)
        {
            return '/games/lol/summoners/' . $region . '/' . $summonerName->getSummonerNameForLink();
        }

        /**
         * @param string $championKey
         *
         * @return string
         */
        public function createChampionPageUri($championKey)
        {
            return '/games/lol/champions/' . strtolower($championKey);
        }

        /**
         * @param Region  $region
         * @param mixed   $matchId
         *
         * @return string
         */
        public function createMatchPageUri(Region $region, $matchId)
        {
            return '/games/lol/matches/' . $region . '/' . $matchId;
        }

        /**
         * @param array $summoners
         * @return string
         */
        public function createSummonerComparePageUri(array $summoners)
        {
            return '/games/lol/summoners/compare?summoners=' . implode(',', $summoners);
        }
    }
}
