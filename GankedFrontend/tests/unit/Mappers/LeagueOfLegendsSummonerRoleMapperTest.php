<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Mappers
{

    /**
     * @covers Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRoleMapper
     */
    class LeagueOfLegendsSummonerRoleMapperTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LeagueOfLegendsSummonerRoleMapper
         */
        private $mapper;
        private $dataPoolReader;

        protected function setUp()
        {
            $this->dataPoolReader = $this->getMockBuilder(\Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->mapper = new LeagueOfLegendsSummonerRoleMapper($this->dataPoolReader);
        }

        /**
         * @param string $role
         * @param string $lane
         * @param string $champion
         * @param array  $championTags
         * @param string $expectedValue
         *
         * @dataProvider dataProvider
         */
        public function testMapWorks($role, $lane, $champion, array $championTags = [], $expectedValue)
        {
            $this->dataPoolReader
                ->expects($this->any())
                ->method('getChampionByName')
                ->will($this->returnValue(['tags' => $championTags]));

            $this->assertSame($expectedValue, $this->mapper->map($lane, $role, $champion));
        }

        /**
         * @return array
         */
        public function dataProvider()
        {
            return [
                ['', 'TOP', '', [], 'TOP'],
                ['', 'MID', '', [], 'MIDDLE'],
                ['', 'MIDDLE', '', [], 'MIDDLE'],
                ['', '', '', [], 'UNKNOWN'],
                ['', 'JUNGLE', '', [], 'JUNGLE'],
                ['', 'BOT', '', [], 'SUPPORT'],
                ['DUO_SUPPORT', 'BOT', '', [], 'SUPPORT'],
                ['DUO_CARRY', 'BOT', '', [], 'ADC'],
                ['', 'BOT', '', ['Marksman'], 'ADC'],
            ];
        }

        public function testGetPositionWorks()
        {
            $this->assertSame('TOP', $this->mapper->getPosition(1));
        }

        public function testGetRoleWorks()
        {
            $this->assertSame('DUO', $this->mapper->getRole(1));
        }

        /**
         * @expectedException \InvalidArgumentException
         */
        public function testInvalidPositionThrowsException()
        {
            $this->mapper->getPosition(5);
        }

        /**
         * @expectedException \InvalidArgumentException
         */
        public function testInvalidRoleThrowsException()
        {
            $this->mapper->getRole(5);
        }
    }
}
