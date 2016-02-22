<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Queries
{

    use Ganked\API\Services\FavouritesService;

    class FetchFavouriteSummonersForUserQuery
    {
        /**
         * @var FavouritesService
         */
        private $favouritesService;

        /**
         * @param FavouritesService $favouritesService
         */
        public function __construct(FavouritesService $favouritesService)
        {
            $this->favouritesService = $favouritesService;
        }

        /**
         * @param \MongoId $userId
         *
         * @return \MongoCursor
         */
        public function execute(\MongoId $userId)
        {
            return $this->favouritesService->getFavouriteSummonersForUser($userId);
        }
    }
}
