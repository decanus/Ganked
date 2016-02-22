<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 

namespace Ganked\Frontend\Mappers
{

    /**
     * @covers Ganked\Frontend\Mappers\LeagueOfLegendsRecentGamesMapper
     */
    class LeagueOfLegendsRecentGamesMapperTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LeagueOfLegendsRecentGamesMapper
         */
        private $mapper;
        private $reader;
        private $rolesMapper;

        protected function setUp()
        {
            $this->reader = $this->getMockBuilder(\Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->rolesMapper = $this->getMockBuilder(\Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRoleMapper::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->mapper = new LeagueOfLegendsRecentGamesMapper($this->reader, $this->rolesMapper);
        }

        public function testMapWorks()
        {
            $recentGames['games'][] = [
                'championId' => '266',
                'stats' => [
                    'item1' => '1001', 'item2' => '200', 'win' => true, 'playerPosition' => 1, 'playerRole' => 1
                ]
            ];
            $recentGames['games'][] = ['championId' => '123'];

            $this->reader
                ->expects($this->at(0))
                ->method('hasChampionById')
                ->with('266')
                ->will($this->returnValue(true));

            $this->reader
                ->expects($this->at(1))
                ->method('getChampionById')
                ->with('266')
                ->will($this->returnValue('aatrox'));

            $this->reader
                ->expects($this->at(2))
                ->method('hasItem')
                ->with('1001')
                ->will($this->returnValue(true));

            $this->reader
                ->expects($this->at(3))
                ->method('getItem')
                ->with('1001')
                ->will($this->returnValue(['name' => 'yay']));

            $this->reader
                ->expects($this->at(4))
                ->method('hasItem')
                ->with('200')
                ->will($this->returnValue(false));

            $this->reader
                ->expects($this->at(5))
                ->method('hasChampionById')
                ->with('123')
                ->will($this->returnValue(false));

            $this->rolesMapper->expects($this->once())->method('getPosition')->will($this->returnValue('TOP'));
            $this->rolesMapper->expects($this->once())->method('getRole')->will($this->returnValue('TOP'));
            $this->rolesMapper->expects($this->once())->method('map')->will($this->returnValue('TOP'));

            $result = [
                'games' => [
                    0 => [
                        'championId' => 'aatrox',
                        'stats' => [
                            'item1' => ['name' => 'yay'],
                            'win' => true,
                            'playerPosition' => 1,
                            'playerRole' => 1
                        ],
                        'role' => 'TOP'
                    ]
                ],
                'wins' => 1,
                'kills' => 0,
                'deaths' => 0,
                'assists' => 0,
                'totalGames' => 1,
            ];

            $this->assertSame($result, $this->mapper->map($recentGames));
        }

    }
}
