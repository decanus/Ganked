<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\DataPool
{
    abstract class AbstractDataPool
    {
        /**
         * @var StorageInterface
         */
        private $storageBackend;

        /**
         * @param StorageInterface $storageBackend
         */
        public function __construct(StorageInterface $storageBackend)
        {
            $this->storageBackend = $storageBackend;
        }

        /**
         * @return StorageInterface
         */
        public function getBackend()
        {
            return $this->storageBackend;
        }
    }
}
