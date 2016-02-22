<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Queries
{
    /**
     * @covers Ganked\Frontend\Queries\FetchSummonersByNameQuery
     * @covers \Ganked\Frontend\Queries\AbstractLeagueOfLegendsQuery
     */
    class FetchSummonersByNameQueryTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var FetchSummonersByNameQuery
         */
        private $query;

        private $serviceClient;

        protected function setUp()
        {
            $this->serviceClient = $this->getMockBuilder(\Ganked\Skeleton\Gateways\LoLGateway::class)
                ->setMethods(['getSummonersByName'])
                ->disableOriginalConstructor()
                ->getMock();

            $this->query = new FetchSummonersByNameQuery($this->serviceClient);
        }

        public function testExecuteWorks()
        {
            $name = 'azulio';

            $this->serviceClient
                ->expects($this->once())
                ->method('getSummonersByName')
                ->with($name)
                ->will($this->returnValue('summonerInfo'));

            $this->assertSame('summonerInfo', $this->query->execute($name));
        }
    }
}
