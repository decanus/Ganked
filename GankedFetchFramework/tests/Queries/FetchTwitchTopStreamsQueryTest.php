<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Queries
{
    /**
     * @covers Ganked\Fetch\Queries\FetchTwitchTopStreamsQuery
     */
    class FetchTwitchTopStreamsQueryTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var FetchTwitchTopStreamsQuery
         */
        private $query;
        private $gateway;

        protected function setUp()
        {
            $this->gateway = $this->getMockBuilder(\Ganked\Skeleton\Gateways\TwitchGateway::class)
                ->setMethods(['getTopStreamsForGame'])
                ->disableOriginalConstructor()
                ->getMock();
            $this->query = new FetchTwitchTopStreamsQuery($this->gateway);
        }

        public function testExecuteWorks()
        {
            $this->gateway
                ->expects($this->once())
                ->method('getTopStreamsForGame')
                ->with('test', 1);

            $this->query->execute('test', 1);
        }
    }
}
