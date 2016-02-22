<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class Hash 
    {
        /**
         * @var string
         */
        private $hash;

        /**
         * @param string $string
         * @param string $salt
         */
        public function __construct($string, $salt = '')
        {
            $this->hash = hash('sha256', $string . $salt);
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->hash;
        }
    }
}
