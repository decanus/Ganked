<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Http\Request
{

    use Ganked\Library\ValueObjects\Uri;

    abstract class AbstractRequest implements RequestInterface
    {
        /**
         * @var array
         */
        private $parameters;

        /**
         * @var array
         */
        private $server;

        /**
         * @var array
         */
        private $cookies;

        /**
         * @var Uri
         */
        private $uri;

        /**
         * @param array $parameters
         * @param array $server
         * @param array $cookies
         */
        public function __construct($parameters = [], $server = [], $cookies = [])
        {
            $this->parameters = $parameters;
            $this->server = $server;
            $this->cookies = $cookies;
        }

        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getCookieParameter($key)
        {
            if (!$this->hasCookieParameter($key)) {
                throw new \Exception('Cookie "' . $key . '" not set');
            }

            return $this->cookies[$key];
        }

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasCookieParameter($key)
        {
            return isset($this->cookies[$key]);
        }

        /**
         * @param string $key
         */
        public function removeCookieParameter($key)
        {
            unset($this->cookies[$key]);
        }

        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getServerParameter($key)
        {
            if (!$this->hasServerParameter($key)) {
                throw new \Exception('Server parameter "' . $key . '" not set');
            }

            return $this->server[$key];
        }

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasServerParameter($key)
        {
            return isset($this->server[$key]);
        }

        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getParameter($key)
        {
            if (!$this->hasParameter($key)) {
                throw new \Exception('Parameter "' . $key . '" not found');
            }

            return $this->parameters[$key];
        }

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasParameter($key)
        {
            return isset($this->parameters[$key]);
        }

        /**
         * @return string
         */
        public function getReferer()
        {
            return $this->getServerParameter('HTTP_REFERER');
        }

        /**
         * @return string
         */
        public function getHost()
        {
            return $this->getServerParameter('HTTP_HOST');
        }

        /**
         * @return string
         */
        public function getUserAgent()
        {
            if ($this->hasServerParameter('HTTP_USER_AGENT')) {
                return $this->getServerParameter('HTTP_USER_AGENT');
            }
        }

        /**
         * @return string
         */
        public function getUserIP()
        {
            return $this->getServerParameter('REMOTE_ADDR');
        }

        /**
         * @return array
         */
        public function getParameters()
        {
            return $this->parameters;
        }

        /**
         * @return Uri
         */
        public function getUri()
        {
            if ($this->uri === null) {
                $this->uri = new Uri('https://' . $this->getHost() . $this->getServerParameter('REQUEST_URI'));
            }

            return $this->uri;
        }
    }
}
