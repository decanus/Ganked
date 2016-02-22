<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Curl
{

    use Ganked\Library\ValueObjects\Uri;

    class Curl
    {
        /**
         * @var CurlHandler
         */
        private $curlHandler;

        /**
         * @var CurlMultiHandler
         */
        private $curlMultiHandler;

        /**
         * @param CurlHandler      $curlHandler
         * @param CurlMultiHandler $curlMultiHandler
         */
        public function __construct(CurlHandler $curlHandler, CurlMultiHandler $curlMultiHandler)
        {
            $this->curlHandler = $curlHandler;
            $this->curlMultiHandler = $curlMultiHandler;
        }

        /**
         * @param Uri   $uri
         * @param array $params
         *
         * @return Response
         */
        public function get(Uri $uri, array $params = [])
        {
            return $this->sendRequest('GET', $uri, $params);
        }

        /**
         * @param Uri   $uri
         * @param array $params
         *
         * @return Response
         */
        public function post(Uri $uri, array $params = [])
        {
            return $this->sendRequest('POST', $uri, $params);
        }

        /**
         * @param Uri   $uri
         * @param array $params
         *
         * @return Response
         */
        public function patch(Uri $uri, array $params = [])
        {
            return $this->sendRequest('PATCH', $uri, $params);
        }

        /**
         * @param Uri   $uri
         * @param array $params
         *
         * @return Response
         */
        public function delete(Uri $uri, array $params = [])
        {
            return $this->sendRequest('DELETE', $uri, $params);
        }

        /**
         * @param Uri    $uri
         * @param array  $params
         * @param string $id
         */
        public function getMulti(Uri $uri, array $params = [], $id = '')
        {
            $this->curlMultiHandler->addRequest($uri, $params, $id);
        }

        /**
         * @return Response[]
         */
        public function sendMultiRequest()
        {
            return $this->curlMultiHandler->sendRequest();
        }

        /**
         * @param string $method
         * @param Uri    $uri
         * @param array  $params
         *
         * @return Response
         * @throws \RuntimeException
         */
        private function sendRequest($method, Uri $uri, array $params = [])
        {
            return $this->curlHandler->sendRequest($method, $uri, $params);
        }
    }
}
