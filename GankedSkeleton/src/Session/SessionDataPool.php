<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Session
{

    use Ganked\Library\DataPool\RedisBackend;
    use Ganked\Skeleton\Map;

    class SessionDataPool
    {
        /**
         * @var RedisBackend
         */
        private $redisBackend;

        /**
         * @param RedisBackend $redisBackend
         */
        public function __construct(RedisBackend $redisBackend)
        {
            $this->redisBackend = $redisBackend;
        }

        /**
         * @param string $id
         *
         * @return Map
         */
        public function load($id)
        {
            $sessionData = $this->redisBackend->get('session_' . $id);

            if (!$sessionData) {
                return new Map();
            }

            return unserialize($sessionData);
        }

        /**
         * @param     $id
         * @param Map $data
         */
        public function save($id, Map $data)
        {
            $this->redisBackend->set('session_' . $id, serialize($data));
        }

        /**
         * @param string $id
         * @param int    $expires
         */
        public function expire($id, $expires)
        {
            $this->redisBackend->expires('session_'  . $id, $expires);
        }

        /**
         * @param string $id
         */
        public function destroy($id)
        {
            $this->redisBackend->delete('session_' . $id);
        }

    }
}
