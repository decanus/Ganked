<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Mappers
{

    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;

    class LeagueOfLegendsCurrentGameMapper
    {
        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $leagueOfLegendsDataPoolReader;

        /**
         * @param LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader
         */
        public function __construct(LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader)
        {
            $this->leagueOfLegendsDataPoolReader = $leagueOfLegendsDataPoolReader;
        }

        /**
         * @param array $data
         *
         * @return array
         */
        public function map(array $data = [])
        {
            foreach($data['participants'] as $playerKey => $player) {
                if ($this->leagueOfLegendsDataPoolReader->hasChampionById($player['championId'])) {
                    $player['champion'] = $this->leagueOfLegendsDataPoolReader->getChampionDataById($player['championId']);
                }

                if (isset($player['spell1Id']) && $this->leagueOfLegendsDataPoolReader->hasSpell($player['spell1Id'])) {
                    $player['spell1'] = $this->leagueOfLegendsDataPoolReader->getSpell($player['spell1Id']);
                }

                if (isset($player['spell2Id']) && $this->leagueOfLegendsDataPoolReader->hasSpell($player['spell2Id'])) {
                    $player['spell2'] = $this->leagueOfLegendsDataPoolReader->getSpell($player['spell2Id']);
                }

                $player['stats'] = [];

                $topLane = $this->getTopLane($player);

                if ($topLane !== '') {
                    $player['stats']['topLane'] = $topLane;
                }

                $page = [  ];
                if(isset($player['masteries'])) {
                    $page['masteries'] = $player['masteries'];

                    foreach($page['masteries'] as $key => $mastery) {
                        $page['masteries'][$key]['id'] = $mastery['masteryId'];
                    }
                }

                if (isset($player['runes'])) {
                    foreach($player['runes'] as $key => $rune) {
                        $runeId = $rune['runeId'];

                        if (!$this->leagueOfLegendsDataPoolReader->hasRune($runeId)) {
                            unset($player['runes'][$key]);
                            continue;
                        }

                        $player['runes'][$key]['data'] = $this->leagueOfLegendsDataPoolReader->getRune($runeId);
                    }
                }

                $player['masteries'] = $page;
                $data['participants'][$playerKey] = $player;
            }

            return $data;
        }


        /**
         * @param array $player
         * @return string
         */
        private function getTopLane(array $player)
        {
            $laneCounts = [];

            if (!isset($player['matchlist']['matches'])) {
                return '';
            }

            foreach($player['matchlist']['matches'] as $match) {
                if (!isset($match['lane'])) {
                    continue;
                }

                $lane = $match['lane'];

                if (!isset($laneCounts[$lane])) {
                    $laneCounts[$lane] = 1;
                    continue;
                }

                $laneCounts[$lane]++;
            }

            if ($laneCounts === []) {
                return '';
            }

            $topLane = '';
            $topLaneCount = 0;

            foreach($laneCounts as $lane => $count) {
                if ($count > $topLaneCount) {
                    $topLane = $lane;
                    $topLaneCount = $count;
                }
            }

            return $topLane;
        }
    }
}
