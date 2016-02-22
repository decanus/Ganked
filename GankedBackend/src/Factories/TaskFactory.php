<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Factories\AbstractFactory;

    class TaskFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Backend\Tasks\BuildStaticPageTask
         */
        public function createBuildStaticPageTask()
        {
            return new \Ganked\Backend\Tasks\BuildStaticPageTask(
                $this->getMasterFactory()->createStaticPageBuilder(),
                $this->getMasterFactory()->createStaticPageWriter(),
                $this->getMasterFactory()->createFileBackend()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\BuildChampionPagesTask
         */
        public function createBuildChampionPagesTask()
        {
            return new \Ganked\Backend\Tasks\BuildChampionPagesTask(
                $this->getMasterFactory()->createChampionsPageBuilder(),
                $this->getMasterFactory()->createChampionPageBuilder(),
                $this->getMasterFactory()->createDataPoolReader(),
                $this->getMasterFactory()->createStaticPageWriter()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\LeagueOfLegendsFreeChampionsPushTask
         */
        public function createLeagueOfLegendsFreeChampionsPushTask()
        {
            return new \Ganked\Backend\Tasks\LeagueOfLegendsFreeChampionsPushTask(
                $this->getMasterFactory()->createLoLGateway(),
                $this->getMasterFactory()->createDataPoolWriter()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\InitialTask
         */
        public function createInitialTask()
        {
            return new \Ganked\Backend\Tasks\InitialTask(
                $this->getMasterFactory()->createTaskLocator(),
                $this->getMasterFactory()->createRedisBackend()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\LeagueOfLegendsChallengerLeaderboardsGetTask
         * @throws \Exception
         */
        public function createLeagueOfLegendsChallengerLeaderboardsGetTask()
        {
            return new \Ganked\Backend\Tasks\LeagueOfLegendsChallengerLeaderboardsGetTask(
                $this->getMasterFactory()->createCurlHandle(),
                $this->getMasterFactory()->getConfiguration()->get('leagueOfLegendsChallengerUri'),
                $this->getMasterFactory()->createLeagueOfLegendsLeaderboardMapper(),
                $this->getMasterFactory()->createLeagueOfLegendsLeaderboardWriter()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\LeagueOfLegendsMasterLeaderboardsGetTask
         * @throws \Exception
         */
        public function createLeagueOfLegendsMasterLeaderboardsGetTask()
        {
            return new \Ganked\Backend\Tasks\LeagueOfLegendsMasterLeaderboardsGetTask(
                $this->getMasterFactory()->createCurlHandle(),
                $this->getMasterFactory()->getConfiguration()->get('leagueOfLegendsMasterUri'),
                $this->getMasterFactory()->createLeagueOfLegendsLeaderboardMapper(),
                $this->getMasterFactory()->createLeagueOfLegendsLeaderboardWriter()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\LeagueOfLegendsCurrentPatchGetTask
         * @throws \Exception
         */
        public function createLeagueOfLegendsCurrentPatchGetTask()
        {
            return new \Ganked\Backend\Tasks\LeagueOfLegendsCurrentPatchGetTask(
                $this->getMasterFactory()->createCurlHandle(),
                $this->getMasterFactory()->createDataPoolReader(),
                $this->getMasterFactory()->createDataPoolWriter(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('leagueOfLegendsVersionListUri')),
                $this->getMasterFactory()->createTaskLocator()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\LeagueOfLegendsRunesGetTask
         * @throws \Exception
         */
        public function createLeagueOfLegendsRunesGetTask()
        {
            return new \Ganked\Backend\Tasks\LeagueOfLegendsRunesGetTask(
                new Uri($this->getMasterFactory()->getConfiguration()->get('leagueOfLegendsRunesDownloadUri')),
                $this->getMasterFactory()->createCurlHandle(),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolWriter()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\LeagueOfLegendsMasteriesTemplateBuildTask
         */
        public function createLeagueOfLegendsMasteriesTemplateBuildTask()
        {
            return new \Ganked\Backend\Tasks\LeagueOfLegendsMasteriesTemplateBuildTask(
                $this->getMasterFactory()->createLeagueOfLegendsMasteriesTemplateBuilder(),
                $this->getMasterFactory()->createCurlHandle(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('leagueOfLegendsMasteriesDownloadUri')),
                $this->getMasterFactory()->createDataPoolWriter()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\LeagueOfLegendsItemsGetTask
         * @throws \Exception
         */
        public function createLeagueOfLegendsItemsGetTask()
        {
            return new \Ganked\Backend\Tasks\LeagueOfLegendsItemsGetTask(
                $this->getMasterFactory()->createCurlHandle(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('leagueOfLegendsItemsDownloadUri')),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolWriter()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\LeagueOfLegendsSummonerSpellsGetTask
         * @throws \Exception
         */
        public function createLeagueOfLegendsSummonerSpellsGetTask()
        {
            return new \Ganked\Backend\Tasks\LeagueOfLegendsSummonerSpellsGetTask(
                new Uri($this->getMasterFactory()->getConfiguration()->get('leagueOfLegendsSummonerSpellsDownloadUri')),
                $this->getMasterFactory()->createCurlHandle(),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolWriter()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\LeagueOfLegendsChampionsGetTask
         * @throws \Exception
         */
        public function createLeagueOfLegendsChampionsGetTask()
        {
            return new \Ganked\Backend\Tasks\LeagueOfLegendsChampionsGetTask(
                $this->getMasterFactory()->createCurlHandle(),
                $this->getMasterFactory()->createDataPoolReader(),
                $this->getMasterFactory()->createDataPoolWriter(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('leagueOfLegendsChampionsListDownloadUri')),
                new Uri($this->getMasterFactory()->getConfiguration()->get('leagueOfLegendsChampionDownloadUri'))
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\RssFeedsGetTask
         * @throws \Exception
         */
        public function createRssFeedsGetTask()
        {
            return new \Ganked\Backend\Tasks\RssFeedsGetTask(
                $this->getMasterFactory()->createCurlHandle(),
                $this->getMasterFactory()->getConfiguration()->get('rss'),
                $this->getMasterFactory()->createDataPoolWriter()
            );
        }

        /**
         * @return \Ganked\Backend\Tasks\CounterStrikeAchievementsTemplateBuildTask
         * @throws \Exception
         */
        public function createCounterStrikeAchievementsTemplateBuildTask()
        {
            return new \Ganked\Backend\Tasks\CounterStrikeAchievementsTemplateBuildTask(
                $this->getMasterFactory()->createCounterStrikeAchievementsTemplateBuilder(),
                $this->getMasterFactory()->createCurlHandle(),
                (new Uri($this->getMasterFactory()->getConfiguration()->get('counterStrikeAchievementsDownloadUri'))),
                $this->getMasterFactory()->createDataPoolWriter()
            );
        }
    }
}
