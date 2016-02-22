<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Handlers
{
    /**
     * @covers Ganked\Frontend\Handlers\LeagueOfLegendsSearchHandler
     * @covers \Ganked\Frontend\Handlers\AbstractSearchHandler
     */
    class LeagueOfLegendsSearchHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LeagueOfLegendsSearchHandler
         */
        private $handler;

        private $fetchSummonersByNameQuery;
        private $fetchSummonerForRegionByNameQuery;
        private $saveDefaultLeagueOfLegendsRegionInSessionCommand;
        private $fetchUserFavouriteSummonersQuery;
        private $model;


        protected function setUp()
        {
            $this->fetchSummonersByNameQuery = $this->getMockBuilder(\Ganked\Frontend\Queries\FetchSummonersByNameQuery::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->fetchSummonerForRegionByNameQuery = $this->getMockBuilder(\Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->saveDefaultLeagueOfLegendsRegionInSessionCommand = $this->getMockBuilder(\Ganked\Frontend\Commands\SaveDefaultLeagueOfLegendsRegionInSessionCommand::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->fetchUserFavouriteSummonersQuery = $this->getMockBuilder(\Ganked\Frontend\Queries\FetchUserFavouriteSummonersQuery::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model = $this->getMockBuilder(\Ganked\Frontend\Models\SearchPageModel::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler = new LeagueOfLegendsSearchHandler(
                $this->fetchSummonersByNameQuery,
                $this->fetchSummonerForRegionByNameQuery,
                $this->saveDefaultLeagueOfLegendsRegionInSessionCommand,
                $this->fetchUserFavouriteSummonersQuery
            );
        }

        public function testRunWorks()
        {
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $curlResponse = $this->getMockBuilder(\Ganked\Skeleton\Backends\Wrappers\CurlResponse::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model->expects($this->once())->method('getRequestUri')->will($this->returnValue($uri));

            $name = 'test';
            $uri->expects($this->at(0))->method('hasParameter')->with('name')->will($this->returnValue(true));
            $uri->expects($this->at(1))->method('getParameter')->with('name')->will($this->returnValue($name));
            $uri->expects($this->at(2))->method('getParameter')->with('name')->will($this->returnValue($name));
            $uri->expects($this->at(3))->method('hasParameter')->with('region')->will($this->returnValue(false));

            $this->fetchSummonersByNameQuery
                ->expects($this->once())
                ->method('execute')
                ->with($name)
                ->will($this->returnValue($curlResponse));

            $curlResponse->expects($this->once())->method('getBody')->will($this->returnValue('{}'));

            $this->model->expects($this->once())->method('setSearchResult')->with([]);

            $this->handler->run($this->model);
        }
    }
}
