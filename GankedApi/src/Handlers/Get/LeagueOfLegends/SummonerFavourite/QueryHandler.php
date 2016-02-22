<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite
{

    use Ganked\API\Handlers\QueryHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Models\MongoCursorModel;
    use Ganked\API\Queries\FetchFavouriteSummonersForUserQuery;
    use Ganked\API\Queries\FetchSummonersFromRedisQuery;
    use Ganked\Skeleton\Http\Request\AbstractRequest;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var FetchFavouriteSummonersForUserQuery
         */
        private $fetchFavouriteSummonersForUserQuery;

        /**
         * @var FetchSummonersFromRedisQuery
         */
        private $fetchSummonersFromRedisQuery;

        /**
         * @param FetchFavouriteSummonersForUserQuery $fetchFavouriteSummonersForUserQuery
         * @param FetchSummonersFromRedisQuery        $fetchSummonersFromRedisQuery
         */
        public function __construct(
            FetchFavouriteSummonersForUserQuery $fetchFavouriteSummonersForUserQuery,
            FetchSummonersFromRedisQuery $fetchSummonersFromRedisQuery
        )
        {
            $this->fetchFavouriteSummonersForUserQuery = $fetchFavouriteSummonersForUserQuery;
            $this->fetchSummonersFromRedisQuery = $fetchSummonersFromRedisQuery;
        }

        /**
         * @param AbstractRequest  $request
         * @param ApiModel         $model
         *
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            $paths = $request->getUri()->getExplodedPath();

            $summoners = $this->fetchFavouriteSummonersForUserQuery->execute(new \MongoId($paths[1]));

            $queryArray = [];
            foreach ($summoners as $summoner) {
                $queryArray[] = $summoner['summoner'];
            }

            if ($queryArray === []) {
                $model->setData([]);
                return;
            }

            $model->setData($this->fetchSummonersFromRedisQuery->execute($queryArray));
        }
    }
}
