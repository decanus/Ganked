<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class Uri 
    {
        /**
         * @var array
         */
        private $uri;

        /**
         * @var array
         */
        private $parameters;

        /**
         * @param string $uri
         */
        public function __construct($uri)
        {
            $this->uri = parse_url($uri);

            if (!isset($this->uri['path'])) {
                $this->uri['path'] = '';
            }

            if (!isset($this->uri['scheme'])) {
                $this->uri['scheme'] = 'http';
            }

            if (!isset($this->uri['host'])) {
                $this->uri['host'] = '';
            }

            if (isset($this->uri['query'])) {
                parse_str($this->uri['query'], $this->parameters);
            }

            $this->uri['path'] = urldecode($this->uri['path']);
        }

        /**
         * @return string
         */
        public function getPath()
        {
            return $this->uri['path'];
        }

        /**
         * @return array
         */
        public function getExplodedPath()
        {
            return explode('/', ltrim($this->getPath(), '/'));
        }

        /**
         * @return string
         */
        public function getPort()
        {
            if (!isset($this->uri['port'])) {
                return '';
            }
            return ':' . $this->uri['port'];
        }

        /**
         * @return string
         */
        public function getQuery()
        {
            if (isset($this->uri['query'])) {
                return '?' . $this->uri['query'];
            }
        }

        /**
         * @param string $parameter
         *
         * @return mixed
         */
        public function getParameter($parameter)
        {
            if (isset($this->parameters[$parameter])) {
                return $this->parameters[$parameter];
            }
        }

        /**
         * @param string $parameter
         *
         * @return bool
         */
        public function hasParameter($parameter)
        {
            return isset($this->parameters[$parameter]);
        }

        /**
         * @return string
         */
        public function getHost()
        {
            return $this->uri['host'];
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->uri['scheme'] . '://'. $this->getHost() . $this->getPort() . $this->getPath() . $this->getQuery();
        }
    }
}
