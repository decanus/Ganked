<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Mappers\LeagueOfLegendsCurrentGameMapper;
    use Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper;
    use Ganked\Frontend\Models\SummonerCurrentGamePageModel;
    use Ganked\Frontend\Queries\FetchSummonerCurrentGameQuery;
    use Ganked\Frontend\Renderers\SummonerCurrentGamePageRenderer;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class SummonerCurrentGameController extends AbstractPageController
    {
        /**
         * @var FetchSummonerCurrentGameQuery
         */
        private $fetchSummonerCurrentGameQuery;
        /**
         * @var LeagueOfLegendsSummonerMapper
         */
        private $leagueOfLegendsSummonerMapper;

        /**
         * @var LeagueOfLegendsCurrentGameMapper
         */
        private $leagueOfLegendsCurrentGameMapper;

        /**
         * @param AbstractResponse                 $response
         * @param FetchSessionCookieQuery          $fetchSessionCookieQuery
         * @param SummonerCurrentGamePageRenderer  $renderer
         * @param SummonerCurrentGamePageModel     $model
         * @param WriteSessionCommand              $writeSessionCommand
         * @param StorePreviousUriCommand          $storePreviousUriCommand
         * @param IsSessionStartedQuery            $isSessionStartedQuery
         * @param FetchSummonerCurrentGameQuery    $fetchSummonerCurrentGameQuery
         * @param LeagueOfLegendsSummonerMapper    $leagueOfLegendsSummonerMapper
         * @param LeagueOfLegendsCurrentGameMapper $leagueOfLegendsCurrentGameMapper
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            SummonerCurrentGamePageRenderer $renderer,
            SummonerCurrentGamePageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            FetchSummonerCurrentGameQuery $fetchSummonerCurrentGameQuery,
            LeagueOfLegendsSummonerMapper $leagueOfLegendsSummonerMapper,
            LeagueOfLegendsCurrentGameMapper $leagueOfLegendsCurrentGameMapper
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

            $this->fetchSummonerCurrentGameQuery = $fetchSummonerCurrentGameQuery;
            $this->leagueOfLegendsSummonerMapper = $leagueOfLegendsSummonerMapper;
            $this->leagueOfLegendsCurrentGameMapper = $leagueOfLegendsCurrentGameMapper;
        }

        protected function doRun()
        {
            /**
             * @var $model SummonerCurrentGamePageModel
             */
            $model = $this->getModel();
            $paths = $model->getRequestUri()->getExplodedPath();
            $data = $this->fetchSummonerCurrentGameQuery->execute(new SummonerName($paths[4]), new Region($paths[3]));

            $model->setSummoner($this->leagueOfLegendsSummonerMapper->map($data));

            if ($data['game'] === null) {
                return;
            }

            $model->setCurrentGame($this->leagueOfLegendsCurrentGameMapper->map($data['game']));
        }
    }
}
