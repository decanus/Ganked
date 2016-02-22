<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Queries\FetchSummonerComparisonStatsQuery;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class SummonerComparisonPageController extends AbstractPageController
    {
        /**
         * @var FetchSummonerComparisonStatsQuery
         */
        private $fetchSummonerComparisonStatsQuery;

        /**
         * @param AbstractResponse                  $response
         * @param FetchSessionCookieQuery           $fetchSessionCookieQuery
         * @param AbstractPageRenderer              $renderer
         * @param AbstractPageModel                 $model
         * @param WriteSessionCommand               $writeSessionCommand
         * @param StorePreviousUriCommand           $storePreviousUriCommand
         * @param IsSessionStartedQuery             $isSessionStartedQuery
         * @param FetchSummonerComparisonStatsQuery $fetchSummonerComparisonStatsQuery
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            AbstractPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            FetchSummonerComparisonStatsQuery $fetchSummonerComparisonStatsQuery
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

            $this->fetchSummonerComparisonStatsQuery = $fetchSummonerComparisonStatsQuery;
        }

        protected function doRun()
        {
            $request = $this->getRequest();

            if (!$request->hasParameter('summoners')) {
                return;
            }

            $summonersArray = explode(',', $request->getParameter('summoners'));
            $summoners = [];
            foreach ($summonersArray as $key => $summoner) {
                if ($key === 4) {
                    break;
                }

                try {
                    $summoners[] = $this->handleSummoner($summoner);
                } catch (\Exception $e) {
                    continue;
                }
            }

            $this->getModel()->setSummonerData($this->fetchSummonerComparisonStatsQuery->execute($summoners));
        }

        /**
         * @param $summoner
         *
         * @return array
         * @throws \InvalidArgumentException
         */
        private function handleSummoner($summoner)
        {
            $summonerInfo = explode(':', $summoner);

            if (count($summonerInfo) !== 2) {
                throw new \InvalidArgumentException('Summoner does not contain all info');
            }

            $name = new SummonerName($summonerInfo[0]);
            $region = new Region($summonerInfo[1]);

            return ['name' => (string) $name, 'region' => (string) $region];
        }
    }
}
