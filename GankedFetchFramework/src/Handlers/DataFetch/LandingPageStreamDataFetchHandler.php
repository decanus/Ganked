<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Fetch\Handlers\DataFetch
{

    use Ganked\Fetch\Mappers\LandingPageStreamMapper;
    use Ganked\Fetch\Queries\FetchTwitchTopStreamsQuery;
    use Ganked\Skeleton\Http\Request\AbstractRequest;

    class LandingPageStreamDataFetchHandler implements DataFetchHandlerInterface
    {
        /**
         * @var FetchTwitchTopStreamsQuery
         */
        private $fetchTwitchTopStreamsQuery;

        /**
         * @var LandingPageStreamMapper
         */
        private $landingPageStreamMapper;

        /**
         * @param FetchTwitchTopStreamsQuery $fetchTwitchTopStreamsQuery
         * @param LandingPageStreamMapper    $landingPageStreamMapper
         */
        public function __construct(
            FetchTwitchTopStreamsQuery $fetchTwitchTopStreamsQuery,
            LandingPageStreamMapper $landingPageStreamMapper
        )
        {
            $this->fetchTwitchTopStreamsQuery = $fetchTwitchTopStreamsQuery;
            $this->landingPageStreamMapper = $landingPageStreamMapper;
        }

        /**
         * @param AbstractRequest $request
         *
         * @return array
         * @throws \Exception
         */
        public function execute(AbstractRequest $request)
        {
            if (!$request->hasParameter('game')) {
                return json_encode(['streams' => null]);
            }

            $game = $request->getParameter('game');
            $response = $this->fetchTwitchTopStreamsQuery->execute($game, 10);
            return json_encode($this->landingPageStreamMapper->map(json_decode($response->getBody(), true)));
        }
    }
}