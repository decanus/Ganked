<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\ServiceClients\API
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Services\ServiceClients\AbstractServiceClient;

    class TwitchServiceClient extends AbstractServiceClient
    {
        /**
         * @param string $game
         * @param int    $limit
         *
         * @return string
         */
        public function getTopStreamsForGame($game, $limit)
        {
            $default = [
                CURLOPT_HTTPHEADER => [
                    'Accept: application/vnd.twitchtv.v3+json',
                ],
            ];

            $data = [
                'game' => $game,
                'limit' => $limit,
                'api_version' => 3
            ];

            $uri = new Uri((string) $this->getBaseUri() .'streams');

            try {
                $response = $this->sendGetRequest($uri, $data, $default, 300);
                return $response->getRawResponseBody();
            } catch (\Exception $e) {
                $this->logEmergencyException($e);
                return '{}';
            }
        }
    }
}
