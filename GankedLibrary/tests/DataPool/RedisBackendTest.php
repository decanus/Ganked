<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\DataPool
{
    /**
     * @covers Ganked\Library\DataPool\RedisBackend
     */
    class RedisBackendTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var RedisBackend
         */
        private $backend;

        private $redis;
        private $host;
        private $port;
        private $password;

        protected function setUp()
        {
            $this->redis = $this->getMockBuilder(\Redis::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->host = 'ganked.test';
            $this->port = 1234;
            $this->password = 'password';

            $this->backend = new RedisBackend($this->redis, $this->host, $this->port, $this->password);
        }

        private function redisConnection()
        {
            $this->redis
                ->expects($this->once())
                ->method('connect')
                ->with($this->host, $this->port);

            $this->redis
                ->expects($this->once())
                ->method('auth')
                ->with($this->password);
        }

        public function testSetWorks()
        {
            $key = 'foo';
            $value = 'bar';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('set')
                ->with($key, $value);

            $this->backend->set($key, $value);
        }

        public function testHSetWorks()
        {
            $key = 'foo';
            $value = 'bar';
            $hash = 'hash';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('hSet')
                ->with($hash, $key, $value);

            $this->backend->hSet($hash, $key, $value);
        }

        public function testGetWorks()
        {
            $key = 'foo';
            $value = 'bar';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('get')
                ->with($key)
                ->will($this->returnValue($value));

            $this->assertSame($value, $this->backend->get($key));
        }

        public function testHGetWorks()
        {
            $key = 'foo';
            $value = 'bar';
            $hash = 'test';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('hGet')
                ->with($hash, $key)
                ->will($this->returnValue($value));

            $this->assertSame($value, $this->backend->hGet($hash, $key));
        }

        public function testHasWorks()
        {
            $key = 'foo';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('get')
                ->with($key)
                ->will($this->returnValue(false));

            $this->assertFalse($this->backend->has($key));
        }


        public function testHHasWorks()
        {
            $key = 'foo';
            $hash = 'test';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('hGet')
                ->with($hash, $key)
                ->will($this->returnValue(false));

            $this->assertFalse($this->backend->hHas($hash, $key));
        }

        public function testDeleteWorks()
        {
            $key = 'foo';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('del')
                ->with($key);

            $this->backend->delete($key);
        }

        public function testHDelWorks()
        {
            $hash = 'foo';
            $key = 'foo';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('hDel')
                ->with($hash, $key);

            $this->backend->hDel($hash, $key);
        }

        public function testLTrimWorks()
        {
            $list = 'foo';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('lTrim')
                ->with($list, 0, 5);

            $this->backend->lTrim($list, 0, 5);
        }

        public function testRenameWorks()
        {
            $old = 'foo';
            $new = 'bar';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('rename')
                ->with($old, $new);

            $this->backend->rename($old, $new);
        }

        public function testExpiresWorks()
        {
            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('expire')
                ->with('foo', 10);

            $this->backend->expires('foo', 10);
        }

        public function testGetListReturnsExpectedValue()
        {
            $list = 'foobar';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('lRange')
                ->with($list, 0, -1)
                ->will($this->returnValue([$list]));

            $this->assertSame([$list], $this->backend->getList($list));
        }

        public function testLPushWorks()
        {
            $list = 'foobar';
            $value = 'yay';

            $this->redisConnection();

            $this->redis
                ->expects($this->once())
                ->method('lPush')
                ->with($list, $value);

            $this->backend->lPush($list, $value);
        }

        public function testHGetAllReturnsExpectedValue()
        {
            $this->redisConnection();

            $hash = 'foo';

            $this->redis
                ->expects($this->once())
                ->method('hGetAll')
                ->with($hash)
                ->will($this->returnValue(['foo']));

            $this->assertSame(['foo'], $this->backend->hGetAll($hash));
        }

        public function testHMSetWorks()
        {
            $this->redisConnection();

            $data = ['foo' => 'bar', 'baz' => 'qux'];

            $this->redis
                ->expects($this->once())
                ->method('hMset')
                ->with('hash', $data);

            $this->backend->hMSet('hash', $data);
        }
    }
}
