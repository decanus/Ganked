<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\DataPool
{

    /**
     * @covers Ganked\Library\DataPool\LeagueOfLegendsDataPoolWriter
     * @covers \Ganked\Library\DataPool\AbstractDataPool
     */
    class LeagueOfLegendsDataPoolWriterTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LeagueOfLegendsDataPoolWriter
         */
        private $dataPoolWriter;
        private $redisBackend;

        protected function setUp()
        {
            $this->redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
               ->getMock();

            $this->dataPoolWriter = new LeagueOfLegendsDataPoolWriter($this->redisBackend);
        }

        public function testSetRuneWorks()
        {
            $id = 'foo';
            $data = 'bar';

            $this->redisBackend
                ->expects($this->once())
                ->method('hSet')
                ->with('lol:runes', $id, $data);

            $this->dataPoolWriter->setRune($id, $data);
        }

        public function testSetItemWorks()
        {
            $id = 'foo';
            $data = 'bar';

            $this->redisBackend
                ->expects($this->once())
                ->method('hSet')
                ->with('lol:items', $id, $data);

            $this->dataPoolWriter->setItem($id, $data);
        }
    }
}
