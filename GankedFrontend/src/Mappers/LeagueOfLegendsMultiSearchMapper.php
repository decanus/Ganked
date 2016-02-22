<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Mappers
{

    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;
    use Ganked\Library\ValueObjects\KDA;

    class LeagueOfLegendsMultiSearchMapper
    {
        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $leagueOfLegendsDataPoolReader;

        /**
         * @var LeagueOfLegendsSummonerRoleMapper
         */
        private $leagueOfLegendsSummonerRoleMapper;

        /**
         * @param LeagueOfLegendsDataPoolReader     $leagueOfLegendsDataPoolReader
         * @param LeagueOfLegendsSummonerRoleMapper $leagueOfLegendsSummonerRoleMapper
         */
        public function __construct(
            LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader,
            LeagueOfLegendsSummonerRoleMapper $leagueOfLegendsSummonerRoleMapper
        )
        {
            $this->leagueOfLegendsDataPoolReader = $leagueOfLegendsDataPoolReader;
            $this->leagueOfLegendsSummonerRoleMapper = $leagueOfLegendsSummonerRoleMapper;
        }

        /**
         * @param array $summoners
         *
         * @return array
         * @throws \OutOfBoundsException
         */
        public function map($summoners = [])
        {
            foreach ($summoners as $key => $summoner) {
                if (!isset($summoner['matchlist']['matches'])) {
                    continue;
                }

                $roles = [];
                $champions = [];
                foreach ($summoner['matchlist']['matches'] as $match) {

                    if (isset($match['role'])) {
                        $role = $this->leagueOfLegendsSummonerRoleMapper->map(
                            $match['lane'],
                            $match['role'],
                            $this->leagueOfLegendsDataPoolReader->getChampionById($match['champion'])
                        );

                        if (!isset($roles[$role])) {
                            $roles[$role] = 0;
                        }

                        $roles[$role]++;
                    }

                }

                if (isset($summoner['ranked']['champions'])) {
                    $champions = $this->handleChampions($summoner['ranked']['champions']);
                }

                arsort($roles);
                $summoners[$key]['role'] = key(array_slice($roles, 0, 1));
                $summoners[$key]['champions'] = array_slice($champions, 0, 5);

                unset($summoners[$key]['matchlist']['matches']);
            }

            return $summoners;
        }

        /**
         * @param array $champions
         *
         * @return array
         * @throws \OutOfBoundsException
         */
        public function handleChampions(array $champions)
        {
            $return = [];
            foreach ($champions as $champion) {

                $id = $champion['id'];
                if (!$this->leagueOfLegendsDataPoolReader->hasChampionById($id)) {
                    continue;
                }

                $totalSessionsPlayed = $champion['stats']['totalSessionsPlayed'];

                try {
                    $kills = $champion['stats']['totalChampionKills'] / $totalSessionsPlayed;
                } catch (\Exception $e) {
                    $kills = 0;
                }

                try {
                    $deaths = $champion['stats']['totalDeathsPerSession'] / $totalSessionsPlayed;
                } catch (\Exception $e) {
                    $deaths = 0;
                }

                try {
                    $assists = $champion['stats']['totalAssists'] / $totalSessionsPlayed;
                } catch (\Exception $e) {
                    $assists = 0;
                }

                $kdaRatio = new KDA($kills, $deaths, $assists);

                try {
                    $goldPerGame = $champion['stats']['totalGoldEarned'] / $totalSessionsPlayed;
                } catch (\Exception $e) {
                    $goldPerGame = 0;
                }

                try {
                    $minionKills = $champion['stats']['totalMinionKills'] / $totalSessionsPlayed;
                } catch (\Exception $e) {
                    $minionKills = 0;
                }

                $championName = $this->leagueOfLegendsDataPoolReader->getChampionById($id);

                $return[$id] = [
                    'champion' => $this->leagueOfLegendsDataPoolReader->getChampionByName($championName),
                    'kills' => $kills,
                    'deaths' => $deaths,
                    'assists' => $assists,
                    'kda' => (string) $kdaRatio,
                    'goldPerGame' => $goldPerGame,
                    'creepScore' => $minionKills,
                    'wins' => $champion['stats']['totalSessionsWon'],
                    'losses' => $champion['stats']['totalSessionsLost'],
                ];
            }

            usort($return, function ($a, $b) {

                $aStat = ($a['wins'] - $a['losses']);
                $bStat = ($b['wins'] - $b['losses']);

                if ($aStat === $bStat) {
                    return $b['kda'] - $a['kda'];
                }

                return $bStat - $aStat;
            });

            return $return;
        }
    }
}
