<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class Cookie 
    {
        /**
         * @var string
         */
        private $name;

        /**
         * @var string
         */
        private $value;

        /**
         * @var string
         */
        private $path;

        /**
         * @var string
         */
        private $expires;

        /**
         * @var string
         */
        private $domain;

        /**
         * @var bool
         */
        private $secure;

        /**
         * @var bool
         */
        private $httpOnly;

        /**
         * @param string $name
         * @param string $value
         * @param string $path
         * @param string $expires
         * @param string $domain
         * @param bool   $secure
         * @param bool   $httpOnly
         */
        public function __construct($name, $value, $path = '/', $expires, $domain = '.ganked.net', $secure = true, $httpOnly = true)
        {
            $this->name = $name;
            $this->value = $value;
            $this->path = $path;
            $this->expires = $expires;
            $this->domain = $domain;
            $this->secure = $secure;
            $this->httpOnly = $httpOnly;
        }

        /**
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @return string
         */
        public function getValue()
        {
            return $this->value;
        }

        /**
         * @return string
         */
        public function getPath()
        {
            return $this->path;
        }

        /**
         * @return string
         */
        public function getExpires()
        {
            return $this->expires;
        }

        /**
         * @return string
         */
        public function getDomain()
        {
            return $this->domain;
        }

        /**
         * @return bool
         */
        public function isSecure()
        {
            return $this->secure;
        }

        /**
         * @return bool
         */
        public function isHttpOnly()
        {
            return $this->httpOnly;
        }
    }
}
