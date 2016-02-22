<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\DataPool
{
    /**
     * @covers Ganked\Library\DataPool\DataPoolWriter
     * @covers \Ganked\Library\DataPool\AbstractDataPool
     */
    class DataPoolWriterTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var DataPoolWriter
         */
        private $dataPoolWriter;
        private $redisBackend;

        protected function setUp()
        {
            $this->redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->dataPoolWriter = new DataPoolWriter($this->redisBackend);
        }

        public function testAddSummonerToRecentListWorks()
        {
            $region = 'euw';
            $summoner['id'] = 'foo';

            $this->redisBackend
                ->expects($this->once())
                ->method('lRange')
                ->with('lol:summoners:recent', 0, 3)
                ->will($this->returnValue([json_encode(['region' => 'not euw', 'id' => 'bar'])]));

            $this->redisBackend
                ->expects($this->once())
                ->method('lPush')
                ->with('lol:summoners:recent', json_encode(['id' => 'foo', 'region' => $region]));
            $this->redisBackend
                ->expects($this->once())
                ->method('lTrim')
                ->with('lol:summoners:recent', 0, 3);

            $this->dataPoolWriter->addSummonerToRecentList($region, $summoner);
        }

        public function testSetFreeChampionsWorks()
        {
            $champions = ['foo', 'bar', 'baz'];

            $this->redisBackend
                ->expects($this->at(0))
                ->method('delete')
                ->with('lol:champions:free');

            $this->redisBackend
                ->expects($this->at(1))
                ->method('lPush')
                ->with('lol:champions:free', 'foo');

            $this->redisBackend
                ->expects($this->at(2))
                ->method('lPush')
                ->with('lol:champions:free', 'bar');

            $this->redisBackend
                ->expects($this->at(3))
                ->method('lPush')
                ->with('lol:champions:free', 'baz');

            $this->dataPoolWriter->setFreeChampions($champions);
        }
    }
}
