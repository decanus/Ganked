<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\Cache
{

    use Ganked\Library\Curl\Response;
    use Ganked\Library\DataPool\StorageInterface;

    class Cache
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
         * @param string $key
         *
         * @return bool
         */
        public function hasCache($key)
        {
            return $this->storageBackend->has($this->generateKey($key));
        }

        /**
         * @param string $key
         *
         * @return Response
         */
        public function getCache($key)
        {
            return unserialize($this->storageBackend->get($this->generateKey($key)));
        }

        /**
         * @param string   $key
         * @param Response $response
         * @param int      $expires
         */
        public function setCache($key, Response $response, $expires)
        {
            $key = $this->generateKey($key);
            $this->storageBackend->set($key, serialize($response));
            $this->storageBackend->expires($key, $expires);
        }

        /**
         * @param string $key
         *
         * @return int
         */
        public function getTTL($key)
        {
            return $this->storageBackend->ttl($this->generateKey($key));
        }

        /**
         * @param string $key
         *
         * @return string
         */
        private function generateKey($key)
        {
            return 'cache_' . $key;
        }
    }
}
