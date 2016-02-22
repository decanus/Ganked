<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Mappers\LeagueOfLegendsMatchOverviewMapper;
    use Ganked\Frontend\Models\MatchPageModel;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Queries\FetchMatchForRegionQuery;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class MatchPageController extends AbstractPageController
    {
        /**
         * @var FetchMatchForRegionQuery
         */
        private $fetchMatchForRegionQuery;

        /**
         * @var LeagueOfLegendsMatchOverviewMapper
         */
        private $leagueOfLegendsMatchOverviewMapper;

        /**
         * @param AbstractResponse                   $response
         * @param FetchSessionCookieQuery            $fetchSessionCookieQuery
         * @param AbstractPageRenderer               $renderer
         * @param MatchPageModel                     $model
         * @param WriteSessionCommand                $writeSessionCommand
         * @param StorePreviousUriCommand            $storePreviousUriCommand
         * @param IsSessionStartedQuery              $isSessionStartedQuery
         * @param FetchMatchForRegionQuery           $fetchMatchForRegionQuery
         * @param LeagueOfLegendsMatchOverviewMapper $leagueOfLegendsMatchOverviewMapper
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            MatchPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            FetchMatchForRegionQuery $fetchMatchForRegionQuery,
            LeagueOfLegendsMatchOverviewMapper $leagueOfLegendsMatchOverviewMapper
        )
        {
            parent::__construct(
                $response,
                $fetchSessionCookieQuery,
                $renderer,
                $model,
                $writeSessionCommand,
                $storePreviousUriCommand,
                $isSessionStartedQuery
            );

            $this->fetchMatchForRegionQuery = $fetchMatchForRegionQuery;
            $this->leagueOfLegendsMatchOverviewMapper = $leagueOfLegendsMatchOverviewMapper;
        }

        protected function doRun()
        {
            /**
             * @var $model MatchPageModel
             */
            $model = $this->getModel();
            $paths = $model->getRequestUri()->getExplodedPath();
            $matchId = $paths[4];

            $match = json_decode($this->fetchMatchForRegionQuery->execute($paths[3], $matchId)->getBody(), true);
            $model->setMatchData($this->leagueOfLegendsMatchOverviewMapper->map($match));
        }
    }
}
