<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\ServiceClients\API
{

    use Ganked\Library\Curl\Response;
    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Services\ServiceClients\API\TwitchServiceClient
     * @covers \Ganked\Services\ServiceClients\AbstractServiceClient
     */
    class TwitchServiceClientTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var TwitchServiceClient
         */
        private $serviceClient;

        private $baseUri;
        private $curl;
        private $curlResponse;
        private $redisBackend;

        protected function setUp()
        {
            $this->curl = $this->getMockBuilder(\Ganked\Library\Curl\Curl::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->curlResponse = $this->getMockBuilder(\Ganked\Library\Curl\Response::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->baseUri = new Uri('ganked.test/');

            $this->serviceClient = new TwitchServiceClient($this->redisBackend, $this->curl, $this->baseUri);
        }

        public function testGetTopStreamsForGameWorks()
        {
            $this->curl
                ->expects($this->once())
                ->method('get')
                ->will($this->returnValue($this->curlResponse));

            $this->curlResponse
                ->expects($this->once())
                ->method('getRawResponseBody')
                ->will($this->returnValue('{}'));

            $this->assertSame(
                '{}', $this->serviceClient->getTopStreamsForGame('League of Legends', 1)
            );
        }

        public function testRequestWorksIfHasCache()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('has')
                ->will($this->returnValue(true));

            $curl = new Response;
            $curl->setResponseBody('yay');

            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->will($this->returnValue(serialize($curl)));

            $this->assertSame(
                'yay', $this->serviceClient->getTopStreamsForGame('League of Legends', 1)
            );
        }
    }
}
