<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Mappers\LeagueOfLegendsRecentGamesMapper;
    use Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper;
    use Ganked\Frontend\Models\SummonerPageModel;
    use Ganked\Frontend\Queries\FetchRecentGamesForSummonerQuery;
    use Ganked\Frontend\Queries\HasUserFavouritedSummonerQuery;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class SummonerPageController extends AbstractSummonerPageController
    {

        /**
         * @var FetchRecentGamesForSummonerQuery
         */
        private $fetchRecentGamesForSummoner;

        /**
         * @var LeagueOfLegendsRecentGamesMapper
         */
        private $leagueOfLegendsRecentGamesMapper;

        /**
         * @param AbstractResponse                 $response
         * @param FetchSessionCookieQuery          $fetchSessionCookieQuery
         * @param AbstractPageRenderer             $renderer
         * @param SummonerPageModel                $model
         * @param WriteSessionCommand              $writeSessionCommand
         * @param StorePreviousUriCommand          $storePreviousUriCommand
         * @param IsSessionStartedQuery            $isSessionStartedQuery
         * @param LeagueOfLegendsSummonerMapper    $leagueOfLegendsSummonerMapper
         * @param HasUserFavouritedSummonerQuery   $hasUserFavouritedSummonerQuery
         * @param FetchRecentGamesForSummonerQuery $fetchRecentGamesForSummoner
         * @param LeagueOfLegendsRecentGamesMapper $leagueOfLegendsRecentGamesMapper
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            SummonerPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            LeagueOfLegendsSummonerMapper $leagueOfLegendsSummonerMapper,
            HasUserFavouritedSummonerQuery $hasUserFavouritedSummonerQuery,
            FetchRecentGamesForSummonerQuery $fetchRecentGamesForSummoner,
            LeagueOfLegendsRecentGamesMapper $leagueOfLegendsRecentGamesMapper
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

            $this->fetchRecentGamesForSummoner = $fetchRecentGamesForSummoner;
            $this->leagueOfLegendsRecentGamesMapper = $leagueOfLegendsRecentGamesMapper;
        }

        /**
         * @return array
         */
        protected function getData()
        {
            $paths = $this->getModel()->getRequestUri()->getExplodedPath();
            return json_decode($this->fetchRecentGamesForSummoner->execute($paths[3], $paths[4])->getBody(), true);
        }

        /**
         * @param array $data
         */
        protected function handleData(array $data = [])
        {
            /**
             * @var $model SummonerPageModel
             */
            $model = $this->getModel();

            if (isset($data['recent-games']['games'])) {
                $model->setRecentMatches($this->leagueOfLegendsRecentGamesMapper->map($data['recent-games']));
            }
        }
    }
}
