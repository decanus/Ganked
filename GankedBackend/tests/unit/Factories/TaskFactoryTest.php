<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{
    /**
     * @covers Ganked\Backend\Factories\TaskFactory
     * @uses Ganked\Backend\Factories\BuilderFactory
     * @uses Ganked\Backend\Factories\MapperFactory
     * @uses Ganked\Backend\Factories\LocatorFactory
     * @uses \Ganked\Backend\Tasks\BuildStaticPageTask
     * @uses \Ganked\Backend\Builders\StaticPageBuilder
     * @uses \Ganked\Backend\Builders\ChampionsPageBuilder
     * @uses \Ganked\Backend\Tasks\BuildChampionPagesTask
     * @uses Ganked\Backend\Factories\BackendFactory
     * @uses Ganked\Backend\Writers\StaticPageWriter
     * @uses \Ganked\Backend\Builders\ChampionPageBuilder
     * @uses \Ganked\Backend\Factories\RendererFactory
     * @uses \Ganked\Backend\Locators\RendererLocator
     * @uses \Ganked\Backend\Factories\WriterFactory
     * @uses \Ganked\Backend\Tasks\LeagueOfLegendsMasterLeaderboardsGetTask
     * @uses \Ganked\Backend\Tasks\LeagueOfLegendsChallengerLeaderboardsGetTask
     * @uses \Ganked\Backend\Tasks\InitialTask
     * @uses \Ganked\Backend\Tasks\LeagueOfLegendsFreeChampionsPushTask
     * @uses \Ganked\Backend\Writers\LeagueOfLegendsLeaderboardWriter
     * @uses \Ganked\Backend\Locators\TaskLocator
     * @uses \Ganked\Backend\Tasks\LeagueOfLegendsChampionsGetTask
     * @uses \Ganked\Backend\Tasks\LeagueOfLegendsRunesGetTask
     * @uses \Ganked\Backend\Tasks\LeagueOfLegendsCurrentPatchGetTask
     * @uses \Ganked\Backend\Tasks\LeagueOfLegendsMasteriesTemplateBuildTask
     * @uses \Ganked\Backend\Builders\LeagueOfLegendsMasteriesTemplateBuilder
     * @uses \Ganked\Backend\Tasks\LeagueOfLegendsItemsGetTask
     * @uses \Ganked\Backend\Tasks\LeagueOfLegendsSummonerSpellsGetTask
     * @uses \Ganked\Backend\Tasks\CounterStrikeAchievementsTemplateBuildTask
     * @uses \Ganked\Backend\Builders\CounterStrikeAchievementsTemplateBuilder
     */
    class TaskFactoryTest extends GenericFactoryTestHelper
    {
        private $parameters;

        public function setUp()
        {
            $this->parameters = $this->getMockBuilder(\Ganked\Skeleton\Map::class)
                ->disableOriginalConstructor()
                ->getMock();
            parent::setUp();
            $this->getMasterFactory()->addFactory(new \Ganked\Skeleton\Factories\TransformationFactory);
        }

        /**
         * @param $method
         * @param $instance
         * @param array $args
         * @dataProvider provideInstanceNames
         */
        public function testCreateInstanceWorks($method, $instance, $args = [])
        {
            $this->parameters
                ->expects($this->any())
                ->method('has')
                ->with('log')
                ->will($this->returnValue(true));

            $this->parameters
                ->expects($this->any())
                ->method('get')
                ->with('log')
                ->will($this->returnValue('true'));

            parent::testCreateInstanceWorks($method, $instance, [$this->parameters]);
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createBuildStaticPageTask', \Ganked\Backend\Tasks\BuildStaticPageTask::class],
                ['createBuildChampionPagesTask', \Ganked\Backend\Tasks\BuildChampionPagesTask::class],
                ['createLeagueOfLegendsFreeChampionsPushTask', \Ganked\Backend\Tasks\LeagueOfLegendsFreeChampionsPushTask::class],
                ['createInitialTask', \Ganked\Backend\Tasks\InitialTask::class],
                ['createLeagueOfLegendsChallengerLeaderboardsGetTask', \Ganked\Backend\Tasks\LeagueOfLegendsChallengerLeaderboardsGetTask::class],
                ['createLeagueOfLegendsMasterLeaderboardsGetTask', \Ganked\Backend\Tasks\LeagueOfLegendsMasterLeaderboardsGetTask::class],
                ['createLeagueOfLegendsCurrentPatchGetTask', \Ganked\Backend\Tasks\LeagueOfLegendsCurrentPatchGetTask::class],
                ['createLeagueOfLegendsChampionsGetTask', \Ganked\Backend\Tasks\LeagueOfLegendsChampionsGetTask::class],
                ['createLeagueOfLegendsRunesGetTask', \Ganked\Backend\Tasks\LeagueOfLegendsRunesGetTask::class],
                ['createLeagueOfLegendsMasteriesTemplateBuildTask', \Ganked\Backend\Tasks\LeagueOfLegendsMasteriesTemplateBuildTask::class],
                ['createLeagueOfLegendsItemsGetTask', \Ganked\Backend\Tasks\LeagueOfLegendsItemsGetTask::class],
                ['createLeagueOfLegendsSummonerSpellsGetTask', \Ganked\Backend\Tasks\LeagueOfLegendsSummonerSpellsGetTask::class],
                ['createCounterStrikeAchievementsTemplateBuildTask', \Ganked\Backend\Tasks\CounterStrikeAchievementsTemplateBuildTask::class],
            ];
        }
    }
}
