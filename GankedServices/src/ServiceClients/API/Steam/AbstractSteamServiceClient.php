<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\ServiceClients\API
{

    use Ganked\Library\Curl\Curl;
    use Ganked\Library\DataPool\RedisBackend;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Services\ServiceClients\AbstractServiceClient;

    abstract class AbstractSteamServiceClient extends AbstractServiceClient
    {

        /**
         * @var string
         */
        private $appId;

        /**
         * @param RedisBackend $redisBackend
         * @param Curl         $curl
         * @param Uri          $baseUri
         * @param string       $key
         * @param string       $appId
         */
        public function __construct(RedisBackend $redisBackend, Curl $curl, Uri $baseUri, $key = '', $appId)
        {
            parent::__construct($redisBackend, $curl, $baseUri, $key, $appId);
            $this->appId = $appId;
        }


        /**
         * @param string $id
         *
         * @return string
         */
        public function getSteamUserInfoById($id)
        {
            $data = [
                'key' => $this->getKey(),
                'steamids' => $id
            ];

            $requestUri = new Uri((string) $this->getBaseUri() . 'ISteamUser/GetPlayerSummaries/v0002/');

            return $this->sendGetRequest($requestUri, $data, [], 3600)->getRawResponseBody();
        }

        /**
         * @param string $id
         *
         * @return string
         */
        public function getSteamUserById($id)
        {
            return $this->sendGetRequest(new Uri('http://steamcommunity.com/id/' . $id . '?xml=1'), [], [], 7200)->getRawResponseBody();
        }

        /**
         * @param string $steam64
         *
         * @return string
         */
        public function getUserStatsForGame($steam64)
        {
            $data = [
                'appid' => $this->appId,
                'key' => $this->getKey(),
                'steamid' => $steam64
            ];

            $requestUri = new Uri((string) $this->getBaseUri() . 'ISteamUserStats/GetUserStatsForGame/v0002/');
            return $this->sendGetRequest($requestUri, $data, [], 3600)->getRawResponseBody();
        }

        /**
         * @return string
         */
        abstract public function getNewsForApp();

    }
}
