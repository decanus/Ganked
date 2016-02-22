<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\ServiceClients\API
{

    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Services\ServiceClients\API\CounterStrikeServiceClient
     * @covers \Ganked\Services\ServiceClients\AbstractServiceClient
     * @covers \Ganked\Services\ServiceClients\API\AbstractSteamServiceClient
     */
    class CounterStrikeServiceClientTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var CounterStrikeServiceClient
         */
        private $serviceClient;

        private $key;
        private $curl;
        private $uri;
        private $response;
        private $redisBackend;

        protected function setUp()
        {
            $this->key = '1234';
            $this->uri = new Uri('ganked.test^/');
            $this->curl = $this->getMockBuilder(\Ganked\Library\Curl\Curl::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->response = $this->getMockBuilder(\Ganked\Library\Curl\Response::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->serviceClient = new CounterStrikeServiceClient(
                $this->redisBackend,
                $this->curl,
                $this->uri,
                $this->key,
                '730'
            );
        }

        public function testGetUserStatsForGameWorks()
        {
            $id = '1234';

            $data = [
                'appid' => '730',
                'key' => $this->key,
                'steamid' => $id
            ];

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with(new Uri($this->uri . 'ISteamUserStats/GetUserStatsForGame/v0002/'), $data)
                ->will($this->returnValue($this->response));

            $this->response
                ->expects($this->once())
                ->method('getRawResponseBody')
                ->will($this->returnValue('{}'));

            $this->assertSame('{}', $this->serviceClient->getUserStatsForGame($id));
        }

        public function testGetSteamUserInfoByIdWorks()
        {
            $id = '1234';

            $data = [
                'key' => $this->key,
                'steamids' => $id
            ];

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with(new Uri($this->uri . 'ISteamUser/GetPlayerSummaries/v0002/'), $data)
                ->will($this->returnValue($this->response));
            $this->response
                ->expects($this->once())
                ->method('getRawResponseBody')
                ->will($this->returnValue('{}'));

            $this->assertSame('{}', $this->serviceClient->getSteamUserInfoById($id));
        }

        public function testGetSteamUserByIdWorks()
        {
            $id = '1234';

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with(new Uri('http://steamcommunity.com/id/' . $id . '?xml=1'), [])
                ->will($this->returnValue($this->response));
            $this->response
                ->expects($this->once())
                ->method('getRawResponseBody')
                ->will($this->returnValue('{}'));

            $this->assertSame('{}', $this->serviceClient->getSteamUserById($id));
        }

        public function testGetNewsForAppWorks()
        {
            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with(new Uri('http://blog.counter-strike.net/index.php/feed/'))
                ->will($this->returnValue($this->response));
            $this->response
                ->expects($this->once())
                ->method('getRawResponseBody')
                ->will($this->returnValue('{}'));

            $this->assertSame('{}', $this->serviceClient->getNewsForApp());
        }
    }
}
