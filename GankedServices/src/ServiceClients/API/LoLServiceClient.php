<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\ServiceClients\API
{

    use Ganked\Library\Backends\MongoDatabaseBackend;
    use Ganked\Library\Curl\Curl;
    use Ganked\Library\DataPool\DataPoolWriter;
    use Ganked\Library\DataPool\RedisBackend;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Services\ServiceClients\AbstractServiceClient;

    class LoLServiceClient extends AbstractServiceClient
    {
        /**
         * @var DataPoolWriter
         */
        private $dataPoolWriter;

        /**
         * @var MongoDatabaseBackend
         */
        private $mongoDatabaseBackend;

        /**
         * @param RedisBackend         $redisBackend
         * @param Curl                 $curl
         * @param Uri                  $baseUri
         * @param string               $key
         * @param DataPoolWriter       $dataPoolWriter
         * @param MongoDatabaseBackend $mongoDatabaseBackend
         */
        public function __construct(
            RedisBackend $redisBackend,
            Curl $curl,
            Uri $baseUri,
            $key = '',
            DataPoolWriter $dataPoolWriter,
            MongoDatabaseBackend $mongoDatabaseBackend
        )
        {
            parent::__construct($redisBackend, $curl, $baseUri, $key);
            $this->dataPoolWriter = $dataPoolWriter;
            $this->mongoDatabaseBackend = $mongoDatabaseBackend;
        }

        /**
         * @return string
         */
        public function getFreeChampions()
        {
            $data = [
                'freeToPlay' => 'true',
                'api_key' => $this->getKey()
            ];

            $uri = sprintf((string) $this->getBaseUri(), 'euw') . '/v1.2/champion';
            return $this->sendGetRequest(new Uri($uri), $data, [], 0)->getRawResponseBody();
        }

        /**
         * @param string $username
         *
         * @return string
         */
        public function getSummonersByName($username)
        {
            $username = str_replace(' ', '', strtolower($username));
            $regions = ['br', 'eune', 'euw', 'kr', 'lan', 'las', 'na', 'oce', 'ru', 'tr'];
            $result = [];

            $uris = [];
            foreach ($regions as $region) {
                $uris[$region] = $this->buildUri($region, '/v1.4/summoner/by-name/' . $username . '?api_key=' . $this->getKey());
            }

            $responses = $this->sendMultiGet($uris, 3600);

            foreach ($responses as $region => $response) {
                try {
                    $result[$region] = $response->getDecodedJsonResponse()[$username];
                } catch (\Exception $e) {
                    $result[$region] = null;
                }
            }

            return json_encode($result);
        }

        /**
         * @param string $region
         * @param string $username
         *
         * @return string
         */
        public function getRecentGamesForSummoner($region, $username)
        {
            $data = [
                'api_key' => $this->getKey()
            ];

            $summoner = json_decode($this->getSummonerForRegionByName($region, $username), true);
            $response['summoner'] = $summoner;

            $uri = $this->buildUri($region , '/v1.3/game/by-summoner/' . $summoner['id'] . '/recent');
            $response['recent-games'] = $this->sendGetRequest($uri, $data, [], 3600)->getDecodedJsonResponse();

            return json_encode($response);
        }

        /**
         * @param string $region
         * @param string $username
         *
         * @return string
         */
        public function getRunesForSummoner($region, $username)
        {
            $data = [
                'api_key' => $this->getKey()
            ];

            $summoner = json_decode($this->getSummonerForRegionByName($region, $username), true);

            $response['summoner'] = $summoner;

            $uri = new Uri(sprintf((string) $this->getBaseUri(), $region) . '/v1.4/summoner/' . $summoner['id'] . '/runes');

            try {
                $response['runes'] = $this->sendGetRequest($uri, $data, [], 3600)->getDecodedJsonResponse()[$summoner['id']];
            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }

            return json_encode($response);
        }

        /**
         * @param string $region
         * @param string $username
         *
         * @return string
         */
        public function getMasteriesForSummoner($region, $username)
        {
            $data = [
                'api_key' => $this->getKey()
            ];

            $summoner = json_decode($this->getSummonerForRegionByName($region, $username), true);
            $response['summoner'] = $summoner;

            $uri = new Uri(sprintf((string) $this->getBaseUri(), $region) . '/v1.4/summoner/' . $summoner['id'] . '/masteries');

            try {
                $response['masteries'] = $this->sendGetRequest($uri, $data, [], 3600)->getDecodedJsonResponse()[$summoner['id']];
            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }

            return json_encode($response);

        }

        /**
         * @param string $region
         * @param string $matchId
         *
         * @return string
         */
        public function getMatchForRegion($region, $matchId)
        {
            $data = [
                'api_key' => $this->getKey(),
                'includeTimeline' => 'true'
            ];

            $uri = sprintf((string)$this->getBaseUri(), $region) . '/v2.2/match/' . $matchId;

            $match = $this->mongoDatabaseBackend->findOneInCollection(
                'lolMatches',
                ['region' => strtoupper($region), 'matchId' => (int) $matchId]
            );

            if ($match !== null) {
                return json_encode($match);
            }

            $response = $this->sendGetRequest(new Uri($uri), $data, [], 3600);

            if ($response->getResponseCode() !== 200) {
                return json_encode([]);
            }

            try {
                $this->mongoDatabaseBackend->insertArrayInCollection($response->getDecodedJsonResponse(), 'lolMatches');
            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }

            return $response->getRawResponseBody();
        }

        /**
         * @param string $region
         * @param array  $summoners
         *
         * @return string
         */
        public function getSummonersForRegion($region, $summoners = [])
        {
            $data = [
                'api_key' => $this->getKey()
            ];

            $uri = new Uri(sprintf((string) $this->getBaseUri(), $region) . '/v1.4/summoner/by-name/' . str_replace(' ', '', implode(',', $summoners)) . '?' . http_build_query($data));

            try {
                $response = $this->sendGetRequest($uri, [], [], 3600)->getDecodedJsonResponse();
                $response['region'] = $region;
                return json_encode($response);
            } catch (\Exception $e) {
                return json_encode([]);
            }
        }

        /**
         * @param array  $summoners
         * @param string $region
         *
         * @return string
         */
        public function getMatchlistsForSummonersInRegion($summoners = [], $region)
        {
            $uri = sprintf((string) $this->getBaseUri(), $region);

            $requests = [];
            foreach ($summoners as $summoner) {
                $requests[$summoner] = new Uri($uri . '/v2.2/matchlist/by-summoner/' . $summoner . '?rankedQueues=RANKED_SOLO_5x5&seasons=SEASON2015&api_key=' . $this->getKey());
            }

            $responses = $this->sendMultiGet($requests, 9000);

            $result = [];
            foreach ($responses as $summoner => $response) {
                $result[$summoner] = $response->getDecodedJsonResponse();
            }

            return json_encode($result);
        }

        /**
         * @param array  $summoners
         * @param string $region
         *
         * @return string
         */
        public function getMatchlistsForSummonersInRegionByUsername($summoners = [], $region)
        {
            $summoners = json_decode($this->getSummonersForRegion($region, $summoners), true);

            $ids = [];

            foreach ($summoners as $summoner) {
                if (!isset($summoner['id'])) {
                    continue;
                }

                $ids[] = $summoner['id'];
            }

            $matchlists = json_decode($this->getMatchlistsForSummonersInRegion($ids, $region), true);

            foreach ($summoners as $key => $summoner) {
                if (!isset($summoner['id'])) {
                    continue;
                }

                $summoners[$key]['matches'] = $matchlists[$summoner['id']];
            }

            return json_encode($summoners);
        }

        /**
         * @param array  $summonerNames
         * @param string $region
         *
         * @return string
         */
        public function summonerMultiSearch(array $summonerNames, $region)
        {
            $summoners = json_decode($this->getSummonersForRegion($region, $summonerNames), true);

            $ids = [];

            foreach ($summoners as $summoner) {
                if (!isset($summoner['id'])) {
                    continue;
                }

                $ids[] = $summoner['id'];
            }

            foreach ($summoners as $summoner) {
                if (!isset($summoner['id'])) {
                    continue;
                }

                $ids[] = $summoner['id'];
            }

            $rankedStats = json_decode($this->getRankedForSummoners($ids, $region), true);
            $matchlists = json_decode($this->getMatchlistsForSummonersInRegion($ids, $region), true);

            foreach ($summoners as $key => $summoner) {
                if (!isset($summoner['id'])) {
                    continue;
                }

                if (isset($rankedStats[$summoner['id']])) {
                    $summoners[$key]['ranked'] = $rankedStats[$summoner['id']];
                }

                if (isset($matchlists[$summoner['id']])) {
                    $summoners[$key]['matchlist'] = $matchlists[$summoner['id']];
                }

            }

            return json_encode($summoners);
        }

        /**
         * @param array  $summoners
         * @param string $region
         *
         * @return array
         */
        public function getRankedForSummoners(array $summoners, $region)
        {
            $uri = sprintf((string) $this->getBaseUri(), $region);

            $requests = [];
            foreach ($summoners as $summoner) {
                $requests[$summoner] = new Uri($uri . '/v1.3/stats/by-summoner/' . $summoner . '/ranked?season=SEASON2015&api_key=' . $this->getKey());
            }

            $responses = $this->sendMultiGet($requests, 9000);

            $result = [];
            foreach ($responses as $summoner => $response) {
                $result[$summoner] = $response->getDecodedJsonResponse();
            }

            return json_encode($result);
        }


        /**
         * @param array $ids
         * @param       $region
         *
         * @return string
         */
        public function getLeagueEntriesForSummoners(array $ids, $region)
        {
            $data = [
                'api_key' => $this->getKey()
            ];

            return $this->sendGetRequest(
                new Uri(sprintf((string) $this->getBaseUri(), $region) . '/v2.5/league/by-summoner/' . implode(',', $ids) . '/entry?' . http_build_query($data)), [], [],
                3600
            )->getRawResponseBody();
        }

        /**
         * @param string $username
         * @param string $region
         *
         * @return string
         */
        public function getLeagueEntryForSummoner($username, $region)
        {
            $data = [
                'api_key' => $this->getKey()
            ];

            $summoner = json_decode($this->getSummonerForRegionByName($region, $username), true);
            $response['summoner'] = $summoner;

            $uri = new Uri(sprintf((string) $this->getBaseUri(), $region) . '/v2.5/league/by-summoner/' . $summoner['id'] . '/entry');

            try {
                $response['entry'] = $this->sendGetRequest($uri, $data, [], 3600)->getDecodedJsonResponse();
            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }

            return json_encode($response);
        }

        /**
         * @param $id
         * @param $region
         *
         * @return string
         */
        public function getLeagueEntryForSummonerById($id, $region)
        {
            $data = [
                'api_key' => $this->getKey()
            ];

            $uri = new Uri(sprintf((string) $this->getBaseUri(), $region) . '/v2.5/league/by-summoner/' . $id . '/entry');

            try {
                return json_encode($this->sendGetRequest($uri, $data, [], 3600)->getDecodedJsonResponse()[$id]);
            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }

            return 'null';
        }

        /**
         * @param string $username
         * @param string $region
         *
         * @return string
         */
        public function getRankedStatsForSummoner($username, $region)
        {
            $data = [
                'api_key' => $this->getKey()
            ];

            $summoner = json_decode($this->getSummonerForRegionByName($region, $username), true);
            $response['summoner'] = $summoner;

            $uri = new Uri(sprintf((string) $this->getBaseUri(), $region) . '/v1.3/stats/by-summoner/' . $summoner['id'] . '/ranked');

            try {
                $response['ranked'] = $this->sendGetRequest($uri, $data, [], 3600)->getDecodedJsonResponse();
            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }


            return json_encode($response);
        }

        /**
         * @param string $id
         * @param string $region
         *
         * @return string
         */
        public function getCurrentGameForSummonerInRegion($id, $region)
        {
            $data = [
                'api_key' => $this->getKey()
            ];

            switch ($region) {
                case 'euw':
                case 'br':
                case 'na':
                case 'tr':
                    $shard = strtoupper($region) . '1';
                    break;
                case 'eune':
                    $shard = 'EUN1';
                    break;
                case 'lan':
                    $shard = 'LA1';
                    break;
                case 'las':
                    $shard = 'LA2';
                    break;
                case 'oce':
                    $shard = 'OC1';
                    break;
                case 'ru':
                    $shard = 'RU';
            }

            $response = $this->sendGetRequest(
                new Uri('https://' . sprintf((string) $this->getBaseUri()->getHost(), $region) . '/observer-mode/rest/consumer/getSpectatorGameInfo/' . $shard . '/' . $id . '?' . http_build_query($data)),
                [],
                [],
                600
            );

            if ($response->getResponseCode() === 200) {
                return $response->getRawResponseBody();
            }

            return 'null';
        }

        /**
         * @param string $summonerName
         * @param string $region
         *
         * @return string
         */
        public function getCurrentGameForSummonerInRegionWithData($summonerName, $region)
        {

            $summoner = json_decode($this->getSummonerForRegionByName($region, $summonerName), true);

            if ($summoner['game'] === null) {
                return json_encode($summoner);
            }

            $participants = [];
            foreach ($summoner['game']['participants'] as $participant) {
                $participants[] = ['id' => $participant['summonerId'], 'champion' => $participant['championId']];
            }

            $data = json_decode($this->getMatchlistsForSummonersFilteredByChampions($participants, $region), true);

            foreach ($summoner['game']['participants'] as $key => $participant) {
                if (!isset($data[$participant['summonerId']])) {
                    continue;
                }

                $summoner['game']['participants'][$key]['matchlist'] = $data[$participant['summonerId']];
            }

            return json_encode($summoner);
        }

        /**
         * @param array $summoners
         * @param string $region
         *
         * @return string
         */
        public function getMatchlistsForSummonersFilteredByChampions($summoners, $region)
        {
            $uri = sprintf((string) $this->getBaseUri(), $region);

            $requests = [];
            foreach ($summoners as $summoner) {
                $requests[$summoner['id']] = new Uri($uri . '/v2.2/matchlist/by-summoner/' . $summoner['id'] . '?rankedQueues=RANKED_SOLO_5x5&seasons=SEASON2015&championIds=' . $summoner['champion'] . '&api_key=' . $this->getKey());
            }

            $responses = $this->sendMultiGet($requests, 9000);


            $result = [];
            foreach ($responses as $summoner => $response) {
                $result[$summoner] = $response->getDecodedJsonResponse();
            }

            return json_encode($result);
        }

        /**
         * @param string $username
         * @param string $region
         *
         * @return string
         */
        public function getMatchlistForSummoner($username, $region)
        {
            $data = [
                'api_key' => $this->getKey()
            ];

            $summoner = json_decode($this->getSummonerForRegionByName($region, $username), true);
            $response['summoner'] = $summoner;

            $uri = $this->buildUri($region, '/v2.2/matchlist/by-summoner/' . $summoner['id']);

            try {
                $response['matchlist'] = $this->sendGetRequest($uri, $data, [], 3600)->getDecodedJsonResponse();
            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }

            return json_encode($response);
        }

        /**
         * @param array $summoners
         *
         * @return string
         */
        public function getSummonerComparisonStats(array $summoners = [])
        {
            $grouped = [];
            foreach ($summoners as $summoner) {
                $grouped[$summoner['region']][] = strtolower($summoner['name']);
            }

            $uris = [];
            $finalData = [];
            foreach ($grouped as $region => $names) {
                $data = json_decode($this->getSummonersForRegion($region, $names), true);

                foreach ($data as $summoner) {
                    if (!isset($summoner['id'])) {
                        continue;
                    }

                    $summoner['region'] = $region;
                    $id = $summoner['id'];

                    $uris['recent' . $id] = $this->buildUri($region,  '/v1.3/game/by-summoner/' . $id . '/recent?api_key=' . $this->getKey());

                    if ($summoner['summonerLevel'] === 30) {
                        $uris['ranked' . $id] = $this->buildUri($region, '/v1.3/stats/by-summoner/' . $id . '/ranked?api_key=' . $this->getKey());
                    }

                    $finalData[$id] = $summoner;
                }
            }

            $comparisonData = $this->sendMultiGet($uris, 3600);
            foreach ($finalData as $summonerId => $summoner) {
                if (isset($comparisonData['recent' . $summonerId])) {
                    try {
                        $finalData[$summonerId]['recent-games'] = $comparisonData['recent' . $summonerId]->getDecodedJsonResponse()['games'];
                    } catch (\Exception $e) {
                        continue;
                    }
                }


                if (isset($comparisonData['ranked' . $summonerId])) {
                    try {
                        $finalData[$summonerId]['ranked'] = $comparisonData['ranked' . $summonerId]->getDecodedJsonResponse()['champions'];
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }

            return json_encode($finalData);
        }

        /**
         * @param string $region
         * @param string $name
         *
         * @return string
         */
        public function getSummonerForRegionByName($region, $name)
        {
            $data = [
                'api_key' => $this->getKey()
            ];

            $username = str_replace(' ', '', strtolower(urldecode($name)));

            $uri = $this->buildUri($region, '/v1.4/summoner/by-name/' . $username . '?' . http_build_query($data));

            try {
                $response = $this->sendGetRequest($uri, [], [], 3600)->getDecodedJsonResponse()[$username];
                $this->dataPoolWriter->addSummonerToRecentList($region, $response);
                $response['ttl'] = $this->getCacheTTL($uri);
                $response['region'] = $region;
                $response['game'] = json_decode($this->getCurrentGameForSummonerInRegion($response['id'], $region), true);

                if ($response['summonerLevel'] === 30) {
                    $response['entry'] = json_decode($this->getLeagueEntryForSummonerById($response['id'], $region), true);
                }

                return json_encode($response);
            } catch (\Exception $e) {
                return json_encode([]);
            }
        }

        /**
         * @param string $region
         * @param string $path
         *
         * @return Uri
         */
        private function buildUri($region, $path)
        {
            return new Uri(sprintf((string) $this->getBaseUri(), $region) . $path);
        }
    }
}
