<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Mappers
{

    /**
     * @covers Ganked\Backend\Mappers\LeagueOfLegendsLeaderboardMapper
     */
    class LeagueOfLegendsLeaderboardMapperTest extends \PHPUnit_Framework_TestCase
    {
        public function testMapReturnsExpectedValue()
        {
            $mapper = new LeagueOfLegendsLeaderboardMapper;

            $region = 'euw';
            $tier = 'master';

            $board = [
                'entries' => [
                    ['foobar']
                ]
            ];

            $this->assertSame(
                [['foobar', 'tier' => $tier, 'region' => $region, 'date' => (new \DateTime)->format('Ymd')]],
                $mapper->map($region, $tier, $board)
            );
        }
    }
}
