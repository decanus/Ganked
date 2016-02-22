<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Handlers\DataFetch
{
    /**
     * @covers Ganked\Fetch\Handlers\DataFetch\LandingPageStreamDataFetchHandler
     */
    class LandingPageStreamDataFetchHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LandingPageStreamDataFetchHandler
         */
        private $handler;

        private $fetchTwitchTopStreamsQuery;
        private $landingPageStreamMapper;
        private $request;
        private $curlResponse;

        protected function setUp()
        {
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->fetchTwitchTopStreamsQuery = $this->getMockBuilder(\Ganked\Fetch\Queries\FetchTwitchTopStreamsQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->landingPageStreamMapper = $this->getMockBuilder(\Ganked\Fetch\Mappers\LandingPageStreamMapper::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->curlResponse = $this->getMockBuilder(\Ganked\Skeleton\Backends\Wrappers\CurlResponse::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler = new LandingPageStreamDataFetchHandler(
                $this->fetchTwitchTopStreamsQuery,
                $this->landingPageStreamMapper
            );
        }

        public function testExecuteWorks()
        {
            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('game')
                ->will($this->returnValue(true));

            $game = 'League of Legends';
            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->with('game')
                ->will($this->returnValue($game));

            $this->fetchTwitchTopStreamsQuery
                ->expects($this->once())
                ->method('execute')
                ->with($game, 10)
                ->will($this->returnValue($this->curlResponse));

            $this->curlResponse->expects($this->once())->method('getBody')->will($this->returnValue('{}'));

            $this->landingPageStreamMapper
                ->expects($this->once())
                ->method('map')
                ->with([])
                ->will($this->returnValue(['streams' => NULL]));

            $this->assertSame(json_encode(['streams' => NULL]), $this->handler->execute($this->request));
        }

        public function testExecuteWorksWithoutGame()
        {
            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('game')
                ->will($this->returnValue(false));

            $this->assertSame(json_encode(['streams' => NULL]), $this->handler->execute($this->request));
        }
    }
}
