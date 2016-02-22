<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Service
{

    use Ganked\Skeleton\Backends\Wrappers\Curl;
    use Ganked\Skeleton\Backends\Wrappers\CurlResponse;

    abstract class AbstractServiceHandler
    {
        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var Request
         */
        private $request;

        /**
         * @var string
         */
        private $serviceUri;

        /**
         * @param string $serviceUri
         * @param Curl $curl
         */
        public function __construct($serviceUri, Curl $curl)
        {
            $this->curl = $curl;
            $this->serviceUri = $serviceUri;
        }

        /**
         * @param Request $request
         *
         * @return CurlResponse
         */
        public function execute(Request $request)
        {
            $this->request = $request;
            return $this->doExecute();
        }

        /**
         * @return string
         */
        protected function getServiceUri()
        {
            return $this->serviceUri;
        }

        /**
         * @return CurlResponse
         */
        abstract protected function doExecute();

        /**
         * @return Request
         */
        protected function getRequest()
        {
            return $this->request;
        }

        /**
         * @return Curl
         */
        protected function getCurl()
        {
            return $this->curl;
        }
    }
}
