<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Service
{

    class Request
    {
        /**
         * @var string
         */
        private $path;

        /**
         * @var string
         */
        private $method;

        /**
         * @var array
         */
        private $data = [];

        /**
         * @var string
         */
        private $token;

        /**
         * @param string $path
         * @param string $token
         * @param string $method
         * @param array  $data
         */
        public function __construct($path, $token, $method, $data = [])
        {
            $this->path = $path;
            $this->token = $token;
            $this->method = $method;
            $this->data = $data;
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
        public function getMethod()
        {
            return $this->method;
        }

        /**
         * @return array
         */
        public function getData()
        {
            return $this->data;
        }

        /**
         * @return string
         */
        public function getToken()
        {
            return $this->token;
        }
    }
}