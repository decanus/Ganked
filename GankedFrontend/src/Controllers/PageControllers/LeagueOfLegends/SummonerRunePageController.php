<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper;
    use Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRunesMapper;
    use Ganked\Frontend\Models\SummonerRunesPageModel;
    use Ganked\Frontend\Queries\FetchRunesForSummonerQuery;
    use Ganked\Frontend\Queries\HasUserFavouritedSummonerQuery;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class SummonerRunePageController extends AbstractSummonerPageController
    {
        /**
         * @var FetchRunesForSummonerQuery
         */
        private $fetchRunesForSummonerQuery;

        /**
         * @var LeagueOfLegendsSummonerRunesMapper
         */
        private $leagueOfLegendsSummonerRunesMapper;

        /**
         * @param AbstractResponse                   $response
         * @param FetchSessionCookieQuery            $fetchSessionCookieQuery
         * @param AbstractPageRenderer               $renderer
         * @param SummonerRunesPageModel             $model
         * @param WriteSessionCommand                $writeSessionCommand
         * @param StorePreviousUriCommand            $storePreviousUriCommand
         * @param IsSessionStartedQuery              $isSessionStartedQuery
         * @param LeagueOfLegendsSummonerMapper      $leagueOfLegendsSummonerMapper
         * @param HasUserFavouritedSummonerQuery     $hasUserFavouritedSummonerQuery
         * @param FetchRunesForSummonerQuery         $fetchRunesForSummonerQuery
         * @param LeagueOfLegendsSummonerRunesMapper $leagueOfLegendsSummonerRunesMapper
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            SummonerRunesPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            LeagueOfLegendsSummonerMapper $leagueOfLegendsSummonerMapper,
            HasUserFavouritedSummonerQuery $hasUserFavouritedSummonerQuery,
            FetchRunesForSummonerQuery $fetchRunesForSummonerQuery,
            LeagueOfLegendsSummonerRunesMapper $leagueOfLegendsSummonerRunesMapper
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

            $this->fetchRunesForSummonerQuery = $fetchRunesForSummonerQuery;
            $this->leagueOfLegendsSummonerRunesMapper = $leagueOfLegendsSummonerRunesMapper;
        }

        /**
         * @return array
         */
        protected function getData()
        {

            $paths = $this->getModel()->getRequestUri()->getExplodedPath();
            $region = new Region($paths[3]);

            return json_decode($this->fetchRunesForSummonerQuery->execute($region, new SummonerName($paths[4]))->getBody(), true);
        }

        /**
         * @param array $data
         */
        protected function handleData(array $data = [])
        {
            /**
             * @var $model SummonerRunesPageModel
             */
            $model = $this->getModel();

            if (isset($data['runes'])) {
                $model->setRunes($this->leagueOfLegendsSummonerRunesMapper->map($data['runes']));
            }
        }
    }
}
