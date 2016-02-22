<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\ServiceClients
{

    use Ganked\Library\Curl\Curl;
    use Ganked\Library\Curl\Response;
    use Ganked\Library\DataPool\RedisBackend;
    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Library\ValueObjects\Uri;

    abstract class AbstractServiceClient implements LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var Uri
         */
        private $baseUri;

        /**
         * @var string
         */
        private $key;

        /**
         * @var RedisBackend
         */
        private $redisBackend;

        /**
         * @param RedisBackend $redisBackend
         * @param Curl         $curl
         * @param Uri          $baseUri
         * @param string       $key
         */
        public function __construct(RedisBackend $redisBackend, Curl $curl, Uri $baseUri, $key = '')
        {
            $this->redisBackend = $redisBackend;
            $this->curl = $curl;
            $this->baseUri = $baseUri;
            $this->key = $key;
        }

        /**
         * @param Uri   $uri
         * @param array $data
         * @param array $configuration
         * @param int   $expires
         *
         * @return Response
         * @throws \RuntimeException
         */
        protected function sendGetRequest(Uri $uri, $data = [], $configuration = [], $expires = 0)
        {
            $cacheUri = $uri;
            if (!empty($data)) {
                $cacheUri = new Uri((string) $uri . '?' . http_build_query($data));
            }

            if ($this->hasCache($cacheUri) && $expires > 0) {
                return unserialize($this->getCache($cacheUri));
            }

            $response = $this->getCurl()->get($uri, $data);

            if ($expires !== 0) {
                $this->cacheResponse($response, $cacheUri, $expires);
            }

            return $response;
        }

        /**
         * @param Uri[] $uris
         * @param int   $expires
         *
         * @return Response[]
         */
        public function sendMultiGet(array $uris, $expires = 0)
        {
            $results = [];

            foreach ($uris as $key => $uri) {

                if ($this->hasCache($uri)) {
                    $results[$key] = unserialize($this->getCache($uri));
                    continue;
                }

                $this->getCurl()->getMulti($uri, [], $key);
            }

            $curlResponses = $this->getCurl()->sendMultiRequest();

            foreach ($curlResponses as $id => $curlResponse) {
                if ($expires !== 0) {
                    $this->cacheResponse($curlResponse, $curlResponse->getUri(), $expires);
                }

                $results[$id] = $curlResponse;
            }

            return $results;
        }

        /**
         * @return Curl
         */
        protected function getCurl()
        {
            return $this->curl;
        }

        /**
         * @return Uri
         */
        protected function getBaseUri()
        {
            return $this->baseUri;
        }

        /**
         * @return string
         */
        protected function getKey()
        {
            return $this->key;
        }

        /**
         * @param Uri $uri
         *
         * @return bool
         */
        protected function hasCache(Uri $uri)
        {
            return $this->redisBackend->has('cache_' . (string) $uri);
        }

        /**
         * @param Uri $uri
         *
         * @return bool|string
         */
        protected function getCache(Uri $uri)
        {
            return $this->redisBackend->get('cache_' . (string) $uri);
        }

        /**
         * @param Uri $uri
         *
         * @return int
         */
        protected function getCacheTTL(Uri $uri)
        {
            return $this->redisBackend->ttl('cache_' . (string) $uri);
        }

        /**
         * @param Response $response
         * @param Uri      $uri
         * @param          $expires
         */
        protected function cacheResponse(Response $response, Uri $uri, $expires)
        {
            $key = 'cache_' . (string) $uri;
            $this->redisBackend->set($key, serialize($response));
            $this->redisBackend->expires($key, $expires);
        }

        /**
         * @return RedisBackend
         */
        protected function getRedis()
        {
            return $this->redisBackend;
        }
    }
}
