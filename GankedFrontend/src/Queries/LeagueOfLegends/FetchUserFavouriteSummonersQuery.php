<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    use Ganked\Library\Gateways\FavouritesGateway;
    use Ganked\Library\ValueObjects\UserId;

    class FetchUserFavouriteSummonersQuery
    {
        /**
         * @var FavouritesGateway
         */
        private $favouritesGateway;

        /**
         * @param FavouritesGateway $favouritesGateway
         */
        public function __construct(FavouritesGateway $favouritesGateway)
        {
            $this->favouritesGateway = $favouritesGateway;
        }

        /**
         * @param UserId $userId
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function execute(UserId $userId)
        {
            return $this->favouritesGateway->getFavouriteSummoners($userId);
        }
    }
}
