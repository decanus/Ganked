<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{

    use Ganked\Library\DataPool\RedisBackend;
    use Ganked\Skeleton\Session\Session;

    class SessionFactory extends AbstractFactory
    {
        /**
         * @var Session
         */
        private $session;

        private $redisBackend;

        /**
         * @param RedisBackend $redisBackend
         */
        public function __construct(RedisBackend $redisBackend)
        {
            $this->redisBackend = $redisBackend;
        }

        /**
         * @return Session
         */
        public function createSession()
        {
            if ($this->session === null) {
                $this->session = new Session(
                    $this->createSessionDataPool()
                );
            }

            return $this->session;
        }

        /**
         * @return \Ganked\Skeleton\Session\SessionDataPool
         */
        public function createSessionDataPool()
        {
            return new \Ganked\Skeleton\Session\SessionDataPool(
                $this->redisBackend
            );
        }
    }
}
