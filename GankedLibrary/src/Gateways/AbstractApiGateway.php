<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Gateways
{

    use Ganked\Library\Curl\Curl;
    use Ganked\Library\Curl\Response;
    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Library\ValueObjects\Uri;

    abstract class AbstractApiGateway implements LoggerAware
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
        private $apiUri;

        /**
         * @var string
         */
        private $apiKey;

        /**
         * @param Curl   $curl
         * @param Uri    $apiUri
         * @param string $apiKey
         */
        public function __construct(Curl $curl, Uri $apiUri, $apiKey)
        {
            $this->curl = $curl;
            $this->apiUri = $apiUri;
            $this->apiKey = $apiKey;
        }

        /**
         * @param string $path
         * @param array  $params
         *
         * @return \Ganked\Library\Curl\Response
         */
        protected function delete($path, array $params)
        {
            return $this->getCurl()->delete(new Uri((string) $this->apiUri . $path), $params);
        }

        /**
         * @param string $path
         * @param array  $params
         *
         * @return Response
         */
        protected function post($path, array $params = [])
        {
            return $this->getCurl()->post(new Uri((string) $this->apiUri . $path), $params);
        }

        /**
         * @param string $path
         * @param array  $params
         *
         * @return Response
         */
        protected function get($path, array $params = [])
        {
            return $this->getCurl()->get(new Uri((string) $this->apiUri . $path), $params);
        }

        /**
         * @return Curl
         */
        protected function getCurl()
        {
            return $this->curl;
        }

        /**
         * @return string
         */
        protected function getApiKey()
        {
            return $this->apiKey;
        }
    }
}
