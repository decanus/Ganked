<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Services
{
    use Ganked\Library\Backends\MongoDatabaseBackend;

    abstract class AbstractDatabaseService
    {
        /**
         * @var MongoDatabaseBackend
         */
        private $databaseBackend;

        /**
         * @param MongoDatabaseBackend $databaseBackend
         */
        public function __construct(MongoDatabaseBackend $databaseBackend)
        {
            $this->databaseBackend = $databaseBackend;
        }

        /**
         * @return MongoDatabaseBackend
         */
        protected function getDatabaseBackend()
        {
            return $this->databaseBackend;
        }
    }
}
