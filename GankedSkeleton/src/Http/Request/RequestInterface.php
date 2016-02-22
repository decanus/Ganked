<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Http\Request
{

    use Ganked\Library\ValueObjects\Uri;

    interface RequestInterface
    {
        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getCookieParameter($key);

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasCookieParameter($key);

        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getServerParameter($key);

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasServerParameter($key);

        /**
         * @param string $key
         *
         * @return string
         * @throws \Exception
         */
        public function getParameter($key);

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasParameter($key);

        /**
         * @return Uri
         */
        public function getUri();
    }
}
