<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Session
{

    /**
     * @covers Ganked\Skeleton\Session\SessionDataPool
     */
    class SessionDataPoolTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var SessionDataPool
         */
        private $sessionDataPool;
        private $redisBackend;

        protected function setUp()
        {
            $this->redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->sessionDataPool = new SessionDataPool($this->redisBackend);
        }

        public function testLoadWorksIfMapNotInRedis()
        {
            $sid = '123';

            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('session_' . $sid)
                ->will($this->returnValue(false));

            $this->assertInstanceOf(\Ganked\Skeleton\Map::class, $this->sessionDataPool->load($sid));

        }

        public function testLoadWorksIfMapIsInRedis()
        {
            $sid = '123';

            $map = new \Ganked\Skeleton\Map;
            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('session_' . $sid)
                ->will($this->returnValue(serialize($map)));

            $this->assertInstanceOf(\Ganked\Skeleton\Map::class, $this->sessionDataPool->load($sid));

        }

        public function testSaveWorks()
        {
            $sid = '123';
            $map = new \Ganked\Skeleton\Map;

            $this->redisBackend
                ->expects($this->once())
                ->method('set')
                ->with('session_' . $sid, serialize($map));

            $this->sessionDataPool->save($sid, $map);
        }

        public function testExpireWorks()
        {
            $sid = '123';
            $expire = 1234;

            $this->redisBackend
                ->expects($this->once())
                ->method('expires')
                ->with('session_' . $sid, $expire);

            $this->sessionDataPool->expire($sid, $expire);
        }

        public function testDestroyWorks()
        {
            $sid = '123';

            $this->redisBackend
                ->expects($this->once())
                ->method('delete')
                ->with('session_' . $sid);

            $this->sessionDataPool->destroy($sid);
        }
    }
}
