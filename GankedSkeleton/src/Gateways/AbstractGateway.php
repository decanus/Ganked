<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Gateways
{

    use Ganked\Skeleton\Backends\Wrappers\CurlResponse;
    use Ganked\Skeleton\Service\AbstractServiceHandler;
    use Ganked\Skeleton\Service\Request;

    abstract class AbstractGateway
    {
        /**
         * @var AbstractServiceHandler
         */
        private $serviceHandler;

        /**
         * @var string
         */
        private $token;

        /**
         * @var string
         */
        private $path;

        /**
         * @param AbstractServiceHandler $serviceHandler
         * @param string                 $path
         * @param string                 $token
         */
        public function __construct(AbstractServiceHandler $serviceHandler, $path, $token)
        {
            $this->serviceHandler = $serviceHandler;
            $this->token = $token;
            $this->path = $path;
        }

        /**
         * @return AbstractServiceHandler
         */
        protected function getServiceHandler()
        {
            return $this->serviceHandler;
        }

        /**
         * @return string
         */
        protected function getPath()
        {
            return $this->path;
        }

        /**
         * @return string
         */
        protected function getToken()
        {
            return $this->token;
        }

        /**
         * @param string $name
         * @param array $arguments
         * @return CurlResponse
         */
        public function __call($name, $arguments)
        {
            return $this->getServiceHandler()->execute(new Request($this->getPath(), $this->token, $name, $arguments));
        }
    }
}
