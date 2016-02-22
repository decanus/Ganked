<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper;
    use Ganked\Frontend\Models\SummonerChampionsPageModel;
    use Ganked\Frontend\Queries\FetchRankedStatsForSummonerQuery;
    use Ganked\Frontend\Queries\HasUserFavouritedSummonerQuery;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class SummonerChampionsPageController extends AbstractSummonerPageController
    {
        /**
         * @var FetchRankedStatsForSummonerQuery
         */
        private $fetchRankedStatsForSummonerQuery;

        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $dataPoolReader;

        /**
         * @param AbstractResponse                 $response
         * @param FetchSessionCookieQuery          $fetchSessionCookieQuery
         * @param AbstractPageRenderer             $renderer
         * @param AbstractPageModel                $model
         * @param WriteSessionCommand              $writeSessionCommand
         * @param StorePreviousUriCommand          $storePreviousUriCommand
         * @param IsSessionStartedQuery            $isSessionStartedQuery
         * @param LeagueOfLegendsSummonerMapper    $leagueOfLegendsSummonerMapper
         * @param HasUserFavouritedSummonerQuery   $hasUserFavouritedSummonerQuery
         * @param FetchRankedStatsForSummonerQuery $fetchRankedStatsForSummonerQuery
         * @param LeagueOfLegendsDataPoolReader    $dataPoolReader
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
            FetchRankedStatsForSummonerQuery $fetchRankedStatsForSummonerQuery,
            LeagueOfLegendsDataPoolReader $dataPoolReader
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

            $this->fetchRankedStatsForSummonerQuery = $fetchRankedStatsForSummonerQuery;
            $this->dataPoolReader = $dataPoolReader;
        }

        /**
         * @return array
         */
        protected function getData()
        {
            $paths = $this->getModel()->getRequestUri()->getExplodedPath();

            $result = $this->fetchRankedStatsForSummonerQuery->execute(new Region($paths[3]), new SummonerName($paths[4]));

            if ($result->getHttpStatus() !== 200) {
                // @todo more error handling
            }

            return json_decode($result->getBody(), true);
        }

        /**
         * @param array $data
         */
        protected function handleData(array $data = [])
        {
            /**
             * @var $model SummonerChampionsPageModel
             */
            $model = $this->getModel();

            $data = $data['ranked'];

            if (!isset($data['champions'])) {
                $model->setStats([]);
                return;
            }

            $champions = [];
            foreach ($data['champions'] as $champion) {
                if (!$this->dataPoolReader->hasChampionById($champion['id'])) {
                    continue;
                }

                $champion['champion'] = $this->dataPoolReader->getChampionDataById($champion['id']);
                $champions[] = $champion;
            }

            $model->setStats($champions);
        }
    }
}
