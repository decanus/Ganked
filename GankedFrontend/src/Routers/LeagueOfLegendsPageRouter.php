<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Frontend\ParameterObjects\ControllerParameterObject;
    use Ganked\Frontend\Readers\LeagueOfLegendsReader;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class LeagueOfLegendsPageRouter extends AbstractRouter
    {
        /**
         * @var LeagueOfLegendsReader
         */
        private $leagueOfLegendsReader;

        /**
         * @param MasterFactory         $factory
         * @param LeagueOfLegendsReader $leagueOfLegendsReader
         */
        public function __construct(MasterFactory $factory, LeagueOfLegendsReader $leagueOfLegendsReader)
        {
            parent::__construct($factory);
            $this->leagueOfLegendsReader = $leagueOfLegendsReader;
        }

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         */
        public function route(AbstractRequest $request)
        {
            $uri = $request->getUri();
            $paths = $uri->getExplodedPath();

            if ($paths[0] !== 'games') {
                return;
            }

            if (!isset($paths[1]) || $paths[1] !== 'lol') {
                return;
            }

            if (!isset($paths[2])) {
                return;
            }

            if ($paths[2] === 'matches' && isset($paths[3]) && isset($paths[4])) {

                try {
                    $region = new Region($paths[3]);
                } catch (\Exception $e) {
                    return;
                }

                if (!ctype_digit($paths[4])) {
                    return;
                }

                if ($this->leagueOfLegendsReader->hasMatchForRegionById((string) $region, $paths[4])) {
                    return $this->getFactory()->createMatchPageController(new ControllerParameterObject($uri));
                }
            }

            $controller = null;
            $controller = $this->routeSummonerPages($uri);

            if ($controller instanceof AbstractPageController) {
                return $controller;
            }
        }

        /**
         * @param Uri $uri
         *
         * @return AbstractPageController
         */
        private function routeSummonerPages(Uri $uri)
        {
            $path = $uri->getExplodedPath();

            if ($path[2] !== 'summoners') {
                return;
            }

            if (isset($path[3]) && $path[3] === 'compare') {
                return $this->getFactory()->createSummonerComparisonPageController(new ControllerParameterObject($uri));
            }

            try {
                $region = new Region($path[3]);
            } catch (\Exception $e) {
                return;
            }

            try {
                $summonerName = new SummonerName($path[4]);
            } catch (\Exception $e) {
                return;
            }

            if (!$this->leagueOfLegendsReader->hasSummonerForRegionWithName($region, $summonerName)) {
                return;
            }

            if (!isset($path[5])) {
                return $this->getFactory()->createSummonerPageController(new ControllerParameterObject($uri));
            }

            switch ($path[5]) {
                case 'runes':
                    return $this->getFactory()->createSummonerRunePageController(new ControllerParameterObject($uri));
                case 'masteries':
                    return $this->getFactory()->createSummonerMasteriesPageController(new ControllerParameterObject($uri));
                case 'current':
                    return $this->getFactory()->createSummonerCurrentGamePageController(new ControllerParameterObject($uri));
                case 'champions':
                    return $this->getFactory()->createSummonerChampionsPageController(new ControllerParameterObject($uri));
            }
        }
    }
}
