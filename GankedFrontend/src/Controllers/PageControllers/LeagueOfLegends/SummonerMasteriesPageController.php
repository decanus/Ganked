<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper;
    use Ganked\Frontend\Queries\FetchMasteriesForSummonerQuery;
    use Ganked\Frontend\Queries\HasUserFavouritedSummonerQuery;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class SummonerMasteriesPageController extends AbstractSummonerPageController
    {
        /**
         * @var FetchMasteriesForSummonerQuery
         */
        private $fetchMasteriesForSummonerQuery;

        /**
         * @param AbstractResponse               $response
         * @param FetchSessionCookieQuery        $fetchSessionCookieQuery
         * @param AbstractPageRenderer           $renderer
         * @param AbstractPageModel              $model
         * @param WriteSessionCommand            $writeSessionCommand
         * @param StorePreviousUriCommand        $storePreviousUriCommand
         * @param IsSessionStartedQuery          $isSessionStartedQuery
         * @param LeagueOfLegendsSummonerMapper  $leagueOfLegendsSummonerMapper
         * @param HasUserFavouritedSummonerQuery $hasUserFavouritedSummonerQuery
         * @param FetchMasteriesForSummonerQuery $fetchMasteriesForSummonerQuery
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            AbstractPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            LeagueOfLegendsSummonerMapper $leagueOfLegendsSummonerMapper,
            HasUserFavouritedSummonerQuery $hasUserFavouritedSummonerQuery,
            FetchMasteriesForSummonerQuery $fetchMasteriesForSummonerQuery
        )
        {
            parent::__construct(
                $response,
                $fetchSessionCookieQuery,
                $renderer,
                $model,
                $writeSessionCommand,
                $storePreviousUriCommand,
                $isSessionStartedQuery,
                $leagueOfLegendsSummonerMapper,
                $hasUserFavouritedSummonerQuery
            );

            $this->fetchMasteriesForSummonerQuery = $fetchMasteriesForSummonerQuery;
        }

        /**
         * @return array
         */
        protected function getData()
        {
            $paths = $this->getModel()->getRequestUri()->getExplodedPath();
            return json_decode($this->fetchMasteriesForSummonerQuery->execute($paths[3], $paths[4])->getBody(), true);
        }

        /**
         * @param array $data
         */
        protected function handleData(array $data = [])
        {
            if (isset($data['masteries'])) {
                $this->getModel()->setMasteries($data['masteries']);
            }
        }
    }
}
