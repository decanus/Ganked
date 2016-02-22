<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Services\ServiceClients\API
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Services\ServiceClients\AbstractServiceClient;

    class SteamServiceClient extends AbstractServiceClient
    {
        /**
         * @param array $steamIds
         *
         * @return string
         */
        public function getPlayerBans(array $steamIds = [])
        {
            return $this->sendGetRequest($this->buildUrl('ISteamUser/GetPlayerBans/v1/', ['steamids' => implode(',', $steamIds)]), [], [], 86400)->getRawResponseBody();
        }

        /**
         * @param string $username
         *
         * @return string
         */
        public function resolveVanityUrl($username)
        {
            return $this->sendGetRequest($this->buildUrl('ISteamUser/ResolveVanityURL/v0001/', ['vanityurl' => $username]), [], [], 10800)->getRawResponseBody();
        }

        /**
         * @param string $method
         * @param array  $query
         *
         * @return Uri
         */
        private function buildUrl($method = '', $query = [])
        {
            $query['key'] = $this->getKey();
            return new Uri((string) $this->getBaseUri() . $method . '?' . http_build_query($query));
        }
    }
}
