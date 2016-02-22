<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class Password 
    {
        /**
         * @var string
         */
        private $password;

        /**
         * @param string $password
         */
        public function __construct($password)
        {
            if (strlen($password) < 6) {
                throw new \InvalidArgumentException('Password must contain at least 6 characters');
            }

            $this->password = strip_tags($password);
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->password;
        }
    }
}
