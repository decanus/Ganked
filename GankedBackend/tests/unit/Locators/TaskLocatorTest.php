<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Locators
{
    /**
     * @covers Ganked\Backend\Locators\TaskLocator
     */
    class TaskLocatorTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var TaskLocator
         */
        private $locator;
        private $factory;
        private $request;

        public function testUnknownTaskThrowsException()
        {
            $this->factory = $this->getMockBuilder(\Ganked\Skeleton\Factories\MasterFactory::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->request = $this->getMockBuilder(\Ganked\Backend\Request::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->request
                ->expects($this->exactly(2))
                ->method('getTask')
                ->will($this->returnValue('brosama'));

            $this->locator = new TaskLocator($this->factory);

            $this->setExpectedException(\InvalidArgumentException::class);
            $this->locator->locate($this->request);
        }


        /**
         * @param string $type
         * @param string $calls
         * @dataProvider providesTasksTypes
         */
        public function testLocateWorks($type, $calls)
        {
            $this->factory = $this->getMockBuilder(\Ganked\Skeleton\Factories\MasterFactory::class)
                ->disableOriginalConstructor()
                ->setMethods([$calls])
                ->getMock();

            $task = $this->getMockBuilder('\\Ganked\\Backend\\Tasks\\' . $type)
                ->disableOriginalConstructor()
                ->getMock();

            $this->request = $this->getMockBuilder(\Ganked\Backend\Request::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->request->expects($this->once())
                ->method('getTask')
                ->will($this->returnValue($type));

            $this->locator = new TaskLocator($this->factory);

            $this->factory
                ->expects($this->once())
                ->method($calls)
                ->will($this->returnValue($task));

            $this->assertSame($task, $this->locator->locate($this->request));
        }

        /**
         * @return array
         */
        public function providesTasksTypes()
        {
            return [
                ['BuildStaticPage', 'createBuildStaticPageTask'],
                ['BuildChampionPages', 'createBuildChampionPagesTask'],
                ['LeagueOfLegendsFreeChampionsPush', 'createLeagueOfLegendsFreeChampionsPushTask'],
                ['Initial', 'createInitialTask'],
                ['LeagueOfLegendsChallengerLeaderboardsGet', 'createLeagueOfLegendsChallengerLeaderboardsGetTask'],
                ['LeagueOfLegendsMasterLeaderboardsGet', 'createLeagueOfLegendsMasterLeaderboardsGetTask'],
                ['LeagueOfLegendsCurrentPatchGet', 'createLeagueOfLegendsCurrentPatchGetTask'],
                ['LeagueOfLegendsChampionsGet', 'createLeagueOfLegendsChampionsGetTask'],
                ['LeagueOfLegendsRunesGet', 'createLeagueOfLegendsRunesGetTask'],
                ['LeagueOfLegendsMasteriesTemplateBuild', 'createLeagueOfLegendsMasteriesTemplateBuildTask'],
                ['LeagueOfLegendsItemsGet', 'createLeagueOfLegendsItemsGetTask'],
                ['LeagueOfLegendsSummonerSpellsGet', 'createLeagueOfLegendsSummonerSpellsGetTask'],
            ];
        }
    }
}
