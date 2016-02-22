<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Commands\SaveDefaultLeagueOfLegendsRegionInSessionCommand;
    use Ganked\Frontend\Mappers\LeagueOfLegendsMultiSearchMapper;
    use Ganked\Frontend\Queries\SummonerMultiSearchQuery;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class SummonerMultiSearchController extends AbstractPageController
    {
        /**
         * @var LeagueOfLegendsMultiSearchMapper
         */
        private $multiSearchMapper;

        /**
         * @var SummonerMultiSearchQuery
         */
        private $searchQuery;

        /**
         * @var SaveDefaultLeagueOfLegendsRegionInSessionCommand
         */
        private $saveDefaultLeagueOfLegendsRegionInSessionCommand;

        /**
         * @param AbstractResponse                                 $response
         * @param FetchSessionCookieQuery                          $fetchSessionCookieQuery
         * @param AbstractPageRenderer                             $renderer
         * @param AbstractPageModel                                $model
         * @param WriteSessionCommand                              $writeSessionCommand
         * @param StorePreviousUriCommand                          $storePreviousUriCommand
         * @param IsSessionStartedQuery                            $isSessionStartedQuery
         * @param SummonerMultiSearchQuery                         $searchQuery
         * @param LeagueOfLegendsMultiSearchMapper                 $multiSearchMapper
         * @param SaveDefaultLeagueOfLegendsRegionInSessionCommand $saveDefaultLeagueOfLegendsRegionInSessionCommand
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            AbstractPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            SummonerMultiSearchQuery $searchQuery,
            LeagueOfLegendsMultiSearchMapper $multiSearchMapper,
            SaveDefaultLeagueOfLegendsRegionInSessionCommand $saveDefaultLeagueOfLegendsRegionInSessionCommand
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

            $this->multiSearchMapper = $multiSearchMapper;
            $this->searchQuery = $searchQuery;
            $this->saveDefaultLeagueOfLegendsRegionInSessionCommand = $saveDefaultLeagueOfLegendsRegionInSessionCommand;
        }

        protected function doRun()
        {
            $request = $this->getRequest();

            if (!$request->hasParameter('names') || !$request->hasParameter('region')) {
                return;
            }

            $summoners = explode(',', $request->getParameter('names'));
            $summoners = array_slice($summoners, 0, 5);

            try {
                $region = new Region($request->getParameter('region'));
                $data = $this->searchQuery->execute($summoners, $region);
            } catch (\Exception $e) {
                return;
            }

            $this->getModel()->setSearchResult($this->multiSearchMapper->map($data));
            $this->saveDefaultLeagueOfLegendsRegionInSessionCommand->execute($region);
        }
    }
}
