<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\ServiceClients\API
{

    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Services\ServiceClients\API\LoLServiceClient
     * @covers \Ganked\Services\ServiceClients\AbstractServiceClient
     */
    class LoLServiceClientTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LoLServiceClient
         */
        private $serviceClient;

        private $curl;
        private $baseUri;
        private $key;
        private $response;
        private $redisBackend;
        private $dataPoolWriter;

        protected function setUp()
        {
            $this->curl = $this->getMockBuilder(\Ganked\Library\Curl\Curl::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->baseUri = new Uri('https://%1$s.api.pvp.net/api/lol/%1$s');

            $this->key = '1234';

            $this->response = $this->getMockBuilder(\Ganked\Library\Curl\Response::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->dataPoolWriter = $this->getMockBuilder(\Ganked\Library\DataPool\DataPoolWriter::class)
                ->disableOriginalConstructor()
                ->getMock();
            $mongo = $this->getMockBuilder(\Ganked\Library\Backends\MongoDatabaseBackend::class)
                ->disableOriginalConstructor()
                ->getMock();


            $this->serviceClient = new LoLServiceClient($this->redisBackend, $this->curl, $this->baseUri, $this->key, $this->dataPoolWriter, $mongo);
        }

        public function testGetFreeChampionsWorks()
        {
            $data = [
                'freeToPlay' => 'true',
                'api_key' => '1234'
            ];

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with(new Uri('https://euw.api.pvp.net/api/lol/euw/v1.2/champion', $data))
                ->will($this->returnValue($this->response));

            $this->response
                ->expects($this->once())
                ->method('getRawResponseBody')
                ->will($this->returnValue('{}'));

            $this->assertSame('{}', $this->serviceClient->getFreeChampions());
        }

        public function testGetSummonerForRegionByNameWorks()
        {
            $data = ['api_key' => '1234'];
            $region = 'euw';
            $name = 'test';

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with(new Uri('https://' . $region . '.api.pvp.net/api/lol/' . $region . '/v1.4/summoner/by-name/' . $name . '?' . http_build_query($data)), [])
                ->will($this->returnValue($this->response));

            $this->response
                ->expects($this->once())
                ->method('getDecodedJsonResponse')
                ->will($this->returnValue(''));

            $this->assertSame('[]', $this->serviceClient->getSummonerForRegionByName($region, $name));
        }

//        public function testGetRecentGamesForSummonerWorks()
//        {
//            $data = ['api_key' => '1234'];
//            $region = 'euw';
//            $name = 'test';
//
//            $this->curl
//                ->expects($this->at(0))
//                ->method('get')
//                ->with(new Uri('https://' . $region . '.api.pvp.net/api/lol/' . $region . '/v1.4/summoner/by-name/' . $name . '?' . http_build_query($data)))
//                ->will($this->returnValue($this->response));
//
//            $this->response
//                ->expects($this->at(0))
//                ->method('getDecodedJsonResponse')
//                ->will($this->returnValue([$name => ['id' => '123']]));
//
//            $this->redisBackend->expects($this->once())->method('ttl')->will($this->returnValue('foo'));
//
//            $this->curl
//                ->expects($this->at(1))
//                ->method('get')
//                ->with(new Uri('https://' . $region . '.api.pvp.net/api/lol/' . $region . '/v1.3/game/by-summoner/123/recent'), $data)
//                ->will($this->returnValue($this->response));
//
//            $this->response
//                ->expects($this->at(1))
//                ->method('getDecodedJsonResponse')
//                ->will($this->returnValue([$name => ['id' => '123']]));
//
//            $this->assertSame(
//                '{"summoner":{"id":"123","ttl":"foo","region":"euw"},"recent-games":[]}',
//                $this->serviceClient->getRecentGamesForSummoner($region, $name)
//            );
//        }
    }
}
