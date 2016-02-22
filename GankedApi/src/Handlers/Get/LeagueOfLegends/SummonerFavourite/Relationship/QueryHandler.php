<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\Relationship
{

    use Ganked\API\Handlers\QueryHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Queries\IsFavouritingSummonerQuery;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Skeleton\Http\Request\AbstractRequest;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var IsFavouritingSummonerQuery
         */
        private $isFavouritingSummonerQuery;

        /**
         * @param IsFavouritingSummonerQuery $isFavouritingSummonerQuery
         */
        public function __construct(IsFavouritingSummonerQuery $isFavouritingSummonerQuery)
        {
            $this->isFavouritingSummonerQuery = $isFavouritingSummonerQuery;
        }


        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            $userId = new \MongoId($request->getUri()->getExplodedPath()[1]);

            $model->setData(
                [
                    'isFollowing' => $this->isFavouritingSummonerQuery->execute(
                        $userId,
                        $request->getParameter('summonerId'),
                        new Region($request->getParameter('region'))
                    )
                ]
            );
        }
    }
}
