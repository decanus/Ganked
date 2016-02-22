<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class Salt 
    {
        /**
         * @var string
         */
        private $salt;

        public function __construct()
        {
            $this->salt = md5(mt_rand());
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->salt;
        }
    }
}
