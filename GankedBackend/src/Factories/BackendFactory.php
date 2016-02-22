<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{
    class BackendFactory extends \Ganked\Skeleton\Factories\BackendFactory
    {
        /**
         * @return \Ganked\Library\Backends\MongoDatabaseBackend
         * @throws \Exception
         */
        public function createMongoDatabaseBackend()
        {
            $configuration = $this->getMasterFactory()->getConfiguration();
            return new \Ganked\Library\Backends\MongoDatabaseBackend(
                new \MongoClient($configuration->get('mongoServer'), ['connect' => false]),
                $configuration->get('mongoDatabase')
            );
        }
    }
}
