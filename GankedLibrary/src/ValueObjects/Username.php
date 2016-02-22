<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class Username 
    {
        /**
         * @var string
         */
        private $username;

        /**
         * @param string $username
         *
         * @throws \InvalidArgumentException
         */
        public function __construct($username)
        {
            if (!ctype_alnum($username) || strlen($username) > 50) {
                throw new \InvalidArgumentException('Invalid username');
            }

            $this->username = strip_tags(strtolower($username));
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->username;
        }
    }
}
