<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Mappers
{
    /**
     * @covers Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper
     * @uses \Ganked\Frontend\DataObjects\Summoner
     */
    class LeagueOfLegendsSummonerMapperTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LeagueOfLegendsSummonerMapper
         */
        private $mapper;
        private $fetchSummonerForRegionByName;

        protected function setUp()
        {
            $this->fetchSummonerForRegionByName = $this->getMockBuilder(\Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->mapper = new LeagueOfLegendsSummonerMapper($this->fetchSummonerForRegionByName);
        }

        public function testMapWorks()
        {
            $summoner = ['id' => 1234, 'name' => 'swegger', 'summonerLevel' => 123, 'profileIconId' => 10, 'region' => 'euw', 'ttl' => 123];

            $this->assertInstanceOf(
                \Ganked\Frontend\DataObjects\Summoner::class,
                $this->mapper->map($summoner)
            );
        }
    }
}
