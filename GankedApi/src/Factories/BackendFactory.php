<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
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
