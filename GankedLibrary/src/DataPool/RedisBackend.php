<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\DataPool
{
    class RedisBackend implements StorageInterface
    {
        /**
         * @var \Redis
         */
        private $redis;

        /**
         * @var string
         */
        private $host;

        /**
         * @var string
         */
        private $port;

        /**
         * @var bool
         */
        private $isConnected = false;

        /**
         * @var string
         */
        private $password;

        /**
         * @param \Redis $redis
         * @param string $host
         * @param int    $port
         * @param string $password
         */
        public function __construct(\Redis $redis, $host, $port, $password = '')
        {
            $this->redis = $redis;
            $this->host = $host;
            $this->port = $port;
            $this->password = $password;
        }

        /**
         * @param string $key
         * @param string $value
         */
        public function set($key, $value)
        {
            $this->connect();
            $this->redis->set($key, $value);
        }

        /**
         * @param string $key
         *
         * @return bool|string
         */
        public function get($key)
        {
            $this->connect();
            return $this->redis->get($key);
        }

        /**
         * @param string $key
         */
        public function delete($key)
        {
            $this->connect();
            $this->redis->del($key);
        }

        /**
         * @param string $key
         *
         * @return bool
         */
        public function has($key)
        {
            return $this->get($key) !== false;
        }

        /**
         * @param string $hash
         * @param string $key
         *
         * @return string
         */
        public function hGet($hash, $key)
        {
            $this->connect();
            return $this->redis->hGet($hash, $key);
        }

        /**
         * @param string $hash
         * @param string $key
         * @param string $value
         */
        public function hSet($hash, $key, $value)
        {
            $this->connect();
            $this->redis->hSet($hash, $key, $value);
        }

        /**
         * @param string $hash
         * @param string $key
         *
         * @return bool
         */
        public function hHas($hash, $key)
        {
            return $this->hGet($hash, $key) !== false;
        }

        /**
         * @param string $hash
         * @param string $key
         */
        public function hDel($hash, $key)
        {
            $this->connect();
            $this->redis->hDel($hash, $key);
        }

        /**
         * @param string $list
         * @param string $value
         */
        public function lPush($list, $value)
        {
            $this->connect();
            $this->redis->lPush($list, $value);
        }

        /**
         * @param string $list
         * @param int    $start
         * @param int    $end
         *
         * @return array
         */
        public function lRange($list, $start = 0, $end = -1)
        {
            $this->connect();
            return $this->redis->lRange($list, $start, $end);
        }

        /**
         * @param string $list
         * @param int    $start
         * @param int    $stop
         */
        public function lTrim($list, $start, $stop)
        {
            $this->connect();
            $this->redis->lTrim($list, $start, $stop);
        }

        /**
         * @param string $list
         *
         * @return array
         */
        public function getList($list)
        {
            return $this->lRange($list);
        }

        /**
         * @param string $key
         * @param int    $expires
         */
        public function expires($key, $expires)
        {
            $this->connect();
            $this->redis->expire($key, $expires);
        }

        /**
         * @param string $old
         * @param string $new
         */
        public function rename($old, $new)
        {
            $this->connect();
            $this->redis->rename($old, $new);
        }

        /**
         * @param string $hash
         * @param array $data
         */
        public function hMSet($hash, array $data)
        {
            $this->connect();
            $this->redis->hMset($hash, $data);
        }

        /**
         * @param string $key
         *
         * @return int
         */
        public function ttl($key)
        {
            return $this->redis->ttl($key);
        }

        /**
         * @param string $hash
         *
         * @return array
         */
        public function hGetAll($hash)
        {
            $this->connect();
            return $this->redis->hGetAll($hash);
        }

        private function connect()
        {
            if ($this->isConnected) {
                return;
            }

            $this->redis->connect($this->host, $this->port, 1.0);

            if ($this->password !== '') {
                $this->redis->auth($this->password);
            }
 
            $this->isConnected = true;
        }

        /**
         * @param string $hash
         * @param array  $keys
         *
         * @return array
         */
        public function hMGet($hash, array $keys)
        {
            $this->connect();
            return $this->redis->hMGet($hash, $keys);
        }
    }
}
