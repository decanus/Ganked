<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Services
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;

    class FavouritesService extends AbstractDatabaseService
    {
        /**
         * @param \MongoId $userId
         * @param string   $summonerId
         * @param Region   $region
         *
         * @return array|bool
         */
        public function favouriteSummoner(\MongoId $userId, $summonerId, Region $region)
        {
            return $this->getDatabaseBackend()->insertArrayInCollection(
                ['user' => (string) $userId, 'summoner' => $summonerId, 'region' => (string) $region, 'type' => 'summoner'],
                'favourites'
            );
        }

        /**
         * @param \MongoId $userId
         * @param string   $summonerId
         * @param Region   $region
         */
        public function unfavouriteSummoner(\MongoId $userId, $summonerId, Region $region)
        {
            $this->getDatabaseBackend()->deleteDocument(
                'favourites',
                ['user' => (string) $userId, 'summoner' => $summonerId, 'region' => (string) $region, 'type' => 'summoner']
            );
        }

        /**
         * @param \MongoId $userId
         *
         * @return \MongoCursor
         */
        public function getFavouriteSummonersForUser(\MongoId $userId)
        {
            return $this->getDatabaseBackend()->aggregateCursor(
                'favourites',
                [
                    ['$match' => ['user' => (string) $userId, 'type' => 'summoner']],
                    ['$project' => ['summoner' => ['$concat' => ['$summoner', ':', '$region']]]]
                ]
            );
        }

        /**
         * @param \MongoId $userId
         * @param string   $summonerId
         * @param Region   $region
         *
         * @return bool
         */
        public function favouritedSummoner(\MongoId $userId, $summonerId, Region $region)
        {
            return $this->getDatabaseBackend()->findOneInCollection(
                'favourites',
                ['user' => (string) $userId, 'summoner' => $summonerId, 'region' => (string) $region, 'type' => 'summoner']
            ) !== null;
        }
    }
}
