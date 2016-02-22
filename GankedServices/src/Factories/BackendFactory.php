<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services\Factories
{

    use Ganked\Library\ValueObjects\Uri;

    class BackendFactory extends \Ganked\Skeleton\Factories\BackendFactory
    {
        /**
         * @return \Ganked\Services\Backends\SlackBackend
         * @throws \Exception
         */
        public function createSlackBackend()
        {
            $configuration = $this->getMasterFactory()->getConfiguration();
            return new \Ganked\Services\Backends\SlackBackend(
                $configuration->get('slackToken'),
                $this->getMasterFactory()->createCurl(),
                new Uri($configuration->get('slackBaseUri'))
            );
        }

        /**
         * @return \Ganked\Library\Backends\MongoDatabaseBackend
         * @throws \Exception
         */
        public function createMongoBackend()
        {
            $configuration = $this->getMasterFactory()->getConfiguration();
            return new \Ganked\Library\Backends\MongoDatabaseBackend(
                new \MongoClient($configuration->get('mongoServer')),
                $configuration->get('mongoDatabase')
            );
        }



        /**
         * @return \Ganked\Library\Backends\MongoDatabaseBackend
         * @throws \Exception
         */
        public function createLeagueOfLegendsMongoBackend()
        {
            $configuration = $this->getMasterFactory()->getConfiguration();
            return new \Ganked\Library\Backends\MongoDatabaseBackend(
                new \MongoClient($configuration->get('lol-mongoServer'), ['connect' => false]),
                $configuration->get('lol-mongoDatabase')
            );
        }


        /**
         * @return \Ganked\Library\DataPool\RedisBackend
         * @throws \Exception
         */
        public function createCacheBackend()
        {
            $configuration = $this->getMasterFactory()->getConfiguration();
            return new \Ganked\Library\DataPool\RedisBackend(
                new \Redis(),
                $configuration->get('cache-redisHost'),
                $configuration->get('cache-redisPort'),
                $configuration->get('cache-redisPassword')
            );
        }

    }
}
