<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Mappers
{

    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;

    class LeagueOfLegendsRecentGamesMapper
    {
        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $legendsDataPoolReader;

        /**
         * @var int
         */
        private $wins = 0;

        /**
         * @var int
         */
        private $totalKills = 0;

        /**
         * @var int
         */
        private $totalAssists = 0;

        /**
         * @var int
         */
        private $totalDeaths = 0;

        /**
         * @var int
         */
        private $totalGames = 0;

        /**
         * @var LeagueOfLegendsSummonerRoleMapper
         */
        private $leagueOfLegendsSummonerRoleMapper;

        /**
         * @param LeagueOfLegendsDataPoolReader     $legendsDataPoolReader
         * @param LeagueOfLegendsSummonerRoleMapper $leagueOfLegendsSummonerRoleMapper
         */
        public function __construct(
            LeagueOfLegendsDataPoolReader $legendsDataPoolReader,
            LeagueOfLegendsSummonerRoleMapper $leagueOfLegendsSummonerRoleMapper
        )
        {
            $this->legendsDataPoolReader = $legendsDataPoolReader;
            $this->leagueOfLegendsSummonerRoleMapper = $leagueOfLegendsSummonerRoleMapper;
        }

        /**
         * @param array $recentGames
         * @return array
         */
        public function map(array $recentGames)
        {
            foreach ($recentGames['games'] as $key => $game) {
                try {
                    $recentGames['games'][$key] = $this->handleGame($game);
                } catch (\Exception $e) {
                    unset($recentGames['games'][$key]);
                }
            }

            $recentGames['wins'] = $this->wins;
            $recentGames['kills'] = $this->totalKills;
            $recentGames['deaths'] = $this->totalDeaths;
            $recentGames['assists'] = $this->totalAssists;
            $recentGames['totalGames'] = $this->totalGames;

            return $recentGames;
        }

        /**
         * @param array $game
         *
         * @return array
         * @throws \Exception
         */
        private function handleGame(array $game)
        {
            $id = $game['championId'];

            if (!$this->legendsDataPoolReader->hasChampionById($id)) {
                throw new \Exception('Champion with Id "' . $id . '" not found');
            }

            $game['championId'] = $this->legendsDataPoolReader->getChampionById($id);

            $itemKeys = ['item0', 'item1', 'item2', 'item3', 'item4', 'item5', 'item6'];

            try {
                $position = $this->leagueOfLegendsSummonerRoleMapper->getPosition($game['stats']['playerPosition']);
            } catch (\Exception $e) {
                $position = 'UNKNOWN';
            }

            try {
                $role = $this->leagueOfLegendsSummonerRoleMapper->getRole($game['stats']['playerRole']);
            } catch (\Exception $e) {
                $role = 'UNKNOWN';
            }

            $game['role'] = $this->leagueOfLegendsSummonerRoleMapper->map($position, $role, $game['championId']);

            foreach ($itemKeys as $itemKey) {
                if (!isset($game['stats'][$itemKey])) {
                    continue;
                }

                $item = $game['stats'][$itemKey];

                if (!$this->legendsDataPoolReader->hasItem($item)) {
                    unset($game['stats'][$itemKey]);
                    continue;
                }

                $game['stats'][$itemKey] = $this->legendsDataPoolReader->getItem($item);
            }

            if ($game['stats']['win'] === true) {
                $this->wins += 1;
            }

            if (isset($game['stats']['numDeaths'])) {
                $this->totalDeaths += $game['stats']['numDeaths'];
            }

            if (isset($game['stats']['championsKilled'])) {
                $this->totalKills += $game['stats']['championsKilled'];
            }

            if (isset($game['stats']['assists'])) {
                $this->totalAssists += $game['stats']['assists'];
            }

            $this->totalGames++;

            return $game;
        }
    }
}
