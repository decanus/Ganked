<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Locators
{

    use Ganked\Backend\Request;
    use Ganked\Backend\Tasks\TaskInterface;
    use Ganked\Skeleton\Factories\MasterFactory;

    class TaskLocator
    {
        /**
         * @var MasterFactory
         */
        private $factory;

        /**
         * @param MasterFactory $factory
         */
        public function __construct(MasterFactory $factory)
        {
            $this->factory = $factory;
        }

        /**
         * @param Request $request
         *
         * @return TaskInterface
         * @throws \InvalidArgumentException
         */
        public function locate(Request $request)
        {
            switch ($request->getTask()) {
                case 'BuildStaticPage':
                    return $this->getFactory()->createBuildStaticPageTask();
                case 'BuildChampionPages':
                    return $this->getFactory()->createBuildChampionPagesTask();
                case 'LeagueOfLegendsFreeChampionsPush':
                    return $this->getFactory()->createLeagueOfLegendsFreeChampionsPushTask();
                case 'Initial':
                    return $this->getFactory()->createInitialTask();
                case 'LeagueOfLegendsChallengerLeaderboardsGet':
                    return $this->getFactory()->createLeagueOfLegendsChallengerLeaderboardsGetTask();
                case 'LeagueOfLegendsMasterLeaderboardsGet':
                    return $this->getFactory()->createLeagueOfLegendsMasterLeaderboardsGetTask();
                case 'LeagueOfLegendsCurrentPatchGet':
                    return $this->getFactory()->createLeagueOfLegendsCurrentPatchGetTask();
                case 'LeagueOfLegendsChampionsGet':
                    return $this->getFactory()->createLeagueOfLegendsChampionsGetTask();
                case 'LeagueOfLegendsRunesGet':
                    return $this->getFactory()->createLeagueOfLegendsRunesGetTask();
                case 'LeagueOfLegendsMasteriesTemplateBuild':
                    return $this->getFactory()->createLeagueOfLegendsMasteriesTemplateBuildTask();
                case 'LeagueOfLegendsItemsGet':
                    return $this->getFactory()->createLeagueOfLegendsItemsGetTask();
                case 'LeagueOfLegendsSummonerSpellsGet':
                    return $this->getFactory()->createLeagueOfLegendsSummonerSpellsGetTask();
                case 'RssFeedsGet':
                    return $this->getFactory()->createRssFeedsGetTask();
                case 'CounterStrikeAchievementsTemplateBuild':
                    return $this->getFactory()->createCounterStrikeAchievementsTemplateBuildTask();
                default:
                    throw new \InvalidArgumentException('Task "' . $request->getTask() . '" not found');
            }
        }

        /**
         * @return MasterFactory
         */
        protected function getFactory()
        {
            return $this->factory;
        }
    }
}
