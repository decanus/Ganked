<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Mappers
{

    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;
    use Ganked\Library\ValueObjects\KDA;

    class LeagueOfLegendsMatchOverviewMapper
    {
        /**
         * @var LeagueOfLegendsSummonerRoleMapper
         */
        private $leagueOfLegendsSummonerRoleMapper;

        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $leagueOfLegendsDataPoolReader;

        /**
         * @var array
         */
        private $stats = [];

        /**
         * @var array
         */
        private $requiredStats = [
            'largestKillingSpree',
            'largestMultiKill',
            'firstBloodKill',
            'firstTower',
            'totalDamageDealtToChampions',
            'physicalDamageDealtToChampions',
            'trueDamageDealtToChampions',
            'magicDamageDealtToChampions',
            'largestCriticalStrike',
            'totalDamageTaken',
            'physicalDamageTaken',
            'magicDamageTaken',
            'goldEarned',
            'inhibitorKills',
            'totalTimeCrowdControlDealt',
            'neutralMinionsKilledEnemyJungle',
            'neutralMinionsKilledTeamJungle'
        ];

        /**
         * @var array
         */
        private $items = ['item0', 'item1', 'item2', 'item3', 'item4', 'item5', 'item6'];

        /**
         * @var array
         */
        private $timeline;

        /**
         * @var array
         */
        private $mvpScores = [];

        /**
         * @param LeagueOfLegendsSummonerRoleMapper $leagueOfLegendsSummonerRoleMapper
         * @param LeagueOfLegendsDataPoolReader     $leagueOfLegendsDataPoolReader
         */
        public function __construct(
            LeagueOfLegendsSummonerRoleMapper $leagueOfLegendsSummonerRoleMapper,
            LeagueOfLegendsDataPoolReader $leagueOfLegendsDataPoolReader
        )
        {
            $this->leagueOfLegendsSummonerRoleMapper = $leagueOfLegendsSummonerRoleMapper;
            $this->leagueOfLegendsDataPoolReader = $leagueOfLegendsDataPoolReader;
        }

        /**
         * @param array $data
         *
         * @return array
         * @throws \OutOfBoundsException
         */
        public function map(array $data = [])
        {
            $winners = 0;

            $returnData = [];
            foreach ($data['teams'] as $team) {
                $team['totalGold'] = 0;
                $team['totalKills'] = 0;

                if (isset($team['bans'])) {
                    $team['bans'] = $this->handleBans($team['bans']);
                }

                if (isset($team['winner']) && $team['winner']) {
                    $winners = $team['teamId'];
                }

                $returnData['teams'][$team['teamId']] = $team;
            }

            $returnData['hasTimeline'] = false;
            if (isset($data['timeline'])) {
                $returnData['hasTimeline'] = true;
                $this->timeline = $data['timeline'];
            }

            foreach ($data['participants'] as $key => $participant) {
                $teamId = $participant['teamId'];
                $returnData['teams'][$teamId]['totalGold'] += $participant['stats']['goldEarned'];
                $returnData['teams'][$teamId]['totalKills'] += $participant['stats']['kills'];
                $participant = $this->handleParticipant($participant);

                if (isset($data['participantIdentities'][$key]['player']['summonerName'])) {
                    $participant['summonerName'] = $data['participantIdentities'][$key]['player']['summonerName'];
                }

                $statsData = $participant['stats'];
                $statsData['champion'] = $participant['champion'];
                $stats[] = $statsData;

                $returnData['teams'][$teamId]['participants'][] = $participant;
            }

            $mvp = array_keys($this->mvpScores, max($this->mvpScores));

            foreach ($returnData['teams'][$winners]['participants'] as $key =>  $participant) {
                if ($participant['participantId'] === $mvp) {
                    continue;
                }

                $returnData['teams'][$winners]['participants'][$key]['mvp'] = true;
                break;
            }

            if (isset($data['matchMode'])) {
                $returnData['matchMode'] = $data['matchMode'];
            }

            if (isset($data['mapId'])) {
                $returnData['mapId'] = $data['mapId'];
            }

            if (isset($data['matchCreation'])) {
                $returnData['matchCreation'] = $data['matchCreation'];
            }

            if (isset($data['matchDuration'])) {
                $returnData['matchDuration'] = $data['matchDuration'];
            }

            if (isset($data['matchId'])) {
                $returnData['matchId'] = $data['matchId'];
            }

            if (isset($data['region'])) {
                $returnData['region'] = $data['region'];
            }

            $returnData['stats'] = $this->stats;

            return $returnData;
        }

        /**
         * @param array $participant
         *
         * @return array
         * @throws \InvalidArgumentException
         * @throws \OutOfBoundsException
         */
        private function handleParticipant(array $participant = [])
        {
            $timeline = $participant['timeline'];
            if (isset($timeline['lane']) && isset($timeline['role'])) {
                $participant['lane'] = $this->leagueOfLegendsSummonerRoleMapper->map(
                    $timeline['lane'],
                    $timeline['role'],
                    $this->leagueOfLegendsDataPoolReader->getChampionById($participant['championId'])
                );
            }

            $participant['champion'] = $this->leagueOfLegendsDataPoolReader->getChampionDataById($participant['championId']);

            $stats = $participant['stats'];

            $kills = 0;
            if (isset($stats['kills'])) {
                $kills = $stats['kills'];
            }

            $deaths = 0;
            if (isset($stats['deaths'])) {
                $deaths = $stats['deaths'];
            }

            $assists = 0;
            if (isset($stats['assists'])) {
                $assists = $stats['assists'];
            }

            $this->stats['kda'][] = (string) new KDA($kills, $deaths, $assists);

            $csDelta = 0;
            if (isset($participant['timeline']['creepsPerMinDeltas']['zeroToTen'])) {
                $csDelta = $participant['timeline']['creepsPerMinDeltas']['zeroToTen'] * 10;
            }

            $csDeltaDiff = 0;
            if (isset($participant['timeline']['csDiffPerMinDeltas'])) {
                $csDeltaDiff = sprintf('%f', $participant['timeline']['csDiffPerMinDeltas']['zeroToTen']) * 10;
            }

            $minions = 0;
            if (isset($stats['minionsKilled'])) {
                $minions = $stats['minionsKilled'];
            }

            if (isset($stats['neutralMinionsKilledYourJungle'])) {
                $minions += $stats['neutralMinionsKilledYourJungle'];
            }

            if (isset($stats['neutralMinionsKilledEnemyJungle'])) {
                $minions += $stats['neutralMinionsKilledEnemyJungle'];
            }
            
            $this->stats['kills'][] = $kills;
            $this->stats['deaths'][] = $deaths;
            $this->stats['assists'][] = $assists;
            $this->stats['creepsPerMinDeltas'][] = $csDelta;
            $this->stats['creepsPerMinDeltasDiff'][] = $csDeltaDiff;
            $this->stats['creepScore'][] = $minions;
            $this->stats['champions'][] = $participant['champion'];

            foreach ($this->requiredStats as $stat) {
                if (!isset($stats[$stat])) {
                    $this->stats[$stat][] = 0;
                    continue;
                }

                $this->stats[$stat][] = $stats[$stat];
            }

            foreach($this->items as $itemKey) {
                if (!isset($participant['stats'][$itemKey])) {
                    unset($participant['stats'][$itemKey]);
                    continue;
                }

                $itemId = $participant['stats'][$itemKey];

                if ($itemId === 0 || !$this->leagueOfLegendsDataPoolReader->hasItem($itemId)) {
                    unset($participant['stats'][$itemKey]);
                    continue;
                }

                $participant['stats'][$itemKey] = $this->leagueOfLegendsDataPoolReader->getItem($itemId);
            }

            $id = $participant['participantId'];

            $participant['overTime']['cs'] = [];

            if (isset($stats['winner']) && $stats['winner']) {
                $mvpScore = 0;

                if (isset($stats['totalPlayerScore'])) {
                    $mvpScore += ($stats['totalPlayerScore'] / 3);
                }

                $mvpScore += ($assists / 50);
                $mvpScore += ($kills / 10);

                $this->mvpScores[$id] = $mvpScore;
            }

            if (empty($this->timeline)) {
                return $participant;
            }

            foreach ($this->timeline['frames'] as $frame) {

                if (isset($frame['participantFrames'][$id])) {
                    $newFrame = $frame['participantFrames'][$id];
                    $newFrame['timestamp'] = $frame['timestamp'];
                    $participant['frames'][] = $newFrame;

                    $roundedTime = (int) ceil(round((($frame['timestamp'] / 1000) / 60), 0) /5);

                    if ($roundedTime !== 0) {
                        $minutes = $roundedTime * 5;

                        if (!isset($participant['overTime']['cs'][$minutes])) {
                            $participant['overTime']['cs'][$minutes] = 0;
                        }
                        if (isset($newFrame['minionsKilled'])) {
                            $participant['overTime']['cs'][$minutes] = $newFrame['minionsKilled'];
                        }

                        if (isset($newFrame['jungleMinionsKilled'])) {
                            $participant['overTime']['cs'][$minutes] += $newFrame['jungleMinionsKilled'];
                        }

                        if (!isset($participant['overTime']['xp'][$minutes])) {
                            $participant['overTime']['xp'][$minutes] = 0;
                        }

                        if (isset($newFrame['xp'])) {
                            $participant['overTime']['xp'][$minutes] = $newFrame['xp'];
                        }

                    }

                }

                if (!isset($frame['events'])) {
                    continue;
                }

                foreach ($frame['events'] as $event) {
                    if (!isset($event['participantId']) || $event['participantId'] !== $id) {
                        continue;
                    }

                    $participant['events'][] = $event;
                }
            }

            return $participant;
        }

        /**
         * @param array $bans
         *
         * @return array
         */
        private function handleBans(array $bans = [])
        {
            foreach ($bans as $ban) {
                $return[] = $this->leagueOfLegendsDataPoolReader->getChampionDataById($ban['championId']);
            }

            return $return;
        }
    }
}
