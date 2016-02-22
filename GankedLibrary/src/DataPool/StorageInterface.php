<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\DataPool
{
    interface StorageInterface
    {
        public function set($key, $value);
        public function get($key);
        public function delete($key);

        /**
         * @param string $key
         *
         * @return bool
         */
        public function has($key);
        public function hGet($hash, $key);
        public function hSet($hash, $key, $value);

        /**
         * @param string $hash
         * @param string $key
         *
         * @return bool
         */
        public function hHas($hash, $key);
        public function hDel($hash, $key);

        /**
         * @param string $old
         * @param string $new
         */
        public function rename($old, $new);

        /**
         * @param string $list
         *
         * @return array
         */
        public function getList($list);

        /**
         * @param string $list
         * @param string $value
         */
        public function lPush($list, $value);

        /**
         * @param string $hash
         *
         * @return array
         */
        public function hGetAll($hash);

        /**
         * @param string $hash
         * @param array  $data
         */
        public function hMSet($hash, array $data);

        /**
         * @param string $hash
         * @param array  $keys
         *
         * @return array
         */
        public function hMGet($hash, array $keys);

        /**
         * @param string $list
         * @param int    $start
         * @param int    $end
         *
         * @return array
         */
        public function lRange($list, $start = 0, $end = -1);

        /**
         * @param string $list
         * @param int    $start
         * @param int    $stop
         */
        public function lTrim($list, $start, $stop);

        /**
         * @param string $key
         *
         * @return int
         */
        public function ttl($key);

        /**
         * @param string $key
         * @param int    $expires
         */
        public function expires($key, $expires);

    }
}
