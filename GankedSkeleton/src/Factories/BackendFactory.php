<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{
    class BackendFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Library\Backends\FileBackend
         */
        public function createFileBackend()
        {
            return new \Ganked\Library\Backends\FileBackend;
        }

        /**
         * @return \Ganked\Skeleton\Backends\Wrappers\Curl
         */
        public function createCurl()
        {
            return new \Ganked\Skeleton\Backends\Wrappers\Curl;
        }

        /**
         * @return \Ganked\Library\DataPool\RedisBackend
         * @throws \Exception
         */
        public function createRedisBackend()
        {
            $configuration = $this->getMasterFactory()->getConfiguration();
            return new \Ganked\Library\DataPool\RedisBackend(
                new \Redis(),
                $configuration->get('redisHost'),
                $configuration->get('redisPort'),
                $configuration->get('redisPassword')
            );
        }

        /**
         * @return \Ganked\Library\Backends\DomBackend
         */
        public function createDomBackend()
        {
            return new \Ganked\Library\Backends\DomBackend($this->getMasterFactory()->createFileBackend());
        }
    }
}
