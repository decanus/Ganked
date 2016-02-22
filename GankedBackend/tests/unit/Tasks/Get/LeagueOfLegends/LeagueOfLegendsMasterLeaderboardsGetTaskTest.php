<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Tasks
{

    /**
     * @covers Ganked\Backend\Tasks\LeagueOfLegendsMasterLeaderboardsGetTask
     */
    class LeagueOfLegendsMasterLeaderboardsGetTaskTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LeagueOfLegendsMasterLeaderboardsGetTask
         */
        private $task;
        private $curl;
        private $uri;
        private $leagueOfLegendsLeaderboardMapper;
        private $leagueOfLegendsLeaderboardWriter;
        private $request;


        protected function setUp()
        {
            $this->curl = $this->getMockBuilder(\Ganked\Library\Curl\Curl::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->uri = 'https://%1$s.api.pvp.net/api/lol/%1$s/v2.5/league/challenger?type=RANKED_SOLO_5x5';
            $this->leagueOfLegendsLeaderboardMapper = $this->getMockBuilder(\Ganked\Backend\Mappers\LeagueOfLegendsLeaderboardMapper::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->leagueOfLegendsLeaderboardWriter = $this->getMockBuilder(\Ganked\Backend\Writers\LeagueOfLegendsLeaderboardWriter::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Backend\Request::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->task = new LeagueOfLegendsMasterLeaderboardsGetTask(
                $this->curl,
                $this->uri,
                $this->leagueOfLegendsLeaderboardMapper,
                $this->leagueOfLegendsLeaderboardWriter
            );
        }

        public function testExecuteWorks()
        {
            $this->curl
                ->expects($this->exactly(10))
                ->method('getMulti');

            $response = $this->getMockBuilder(\Ganked\Library\Curl\Response::class)
                ->disableOriginalConstructor()
                ->getMock();

            $responses = ['br' => $response];

            $this->curl
                ->expects($this->once())
                ->method('sendMultiRequest')
                ->will($this->returnValue($responses));

            $data = ['foobar'];
            $response->expects($this->once())->method('getDecodedJsonResponse')->will($this->returnValue($data));

            $this->leagueOfLegendsLeaderboardMapper
                ->expects($this->once())
                ->method('map')
                ->with('br', 'master', $data)
                ->will($this->returnValue(['foo']));

            $this->leagueOfLegendsLeaderboardWriter
                ->expects($this->once())
                ->method('write')
                ->with(['foo']);

            $this->task->run($this->request);
        }
    }
}
