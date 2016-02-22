<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\Gateways
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\UserId;

    class FavouritesGateway extends AbstractApiGateway
    {
        /**
         * @param string $userId
         * @param string $summonerId
         * @param Region $region
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function favouriteSummoner($userId, $summonerId, Region $region)
        {
            return $this->post(
                '/favourites/' . $userId . '/summoners',
                ['summonerId' => $summonerId, 'region' => (string) $region, 'api_key' => $this->getApiKey()]
            );
        }

        /**
         * @param string $userId
         * @param string $summonerId
         * @param Region $region
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function unfavouriteSummoner($userId, $summonerId, Region $region)
        {
            return $this->delete(
                '/favourites/' . $userId . '/summoners',
                ['summonerId' => $summonerId, 'region' => (string) $region, 'api_key' => $this->getApiKey()]
            );
        }

        /**
         * @param string $userId
         * @param string $summonerId
         * @param Region $region
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function favouritedSummoner($userId, $summonerId, Region $region)
        {
            return $this->get(
                '/favourites/' . $userId . '/summoners/show',
                ['summonerId' => $summonerId, 'region' => (string) $region, 'api_key' => $this->getApiKey()]
            );
        }

        /**
         * @param UserId $userId
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function getFavouriteSummoners(UserId $userId)
        {
            return $this->get('/favourites/' . $userId . '/summoners', ['api_key' => $this->getApiKey()]);
        }
    }
}
