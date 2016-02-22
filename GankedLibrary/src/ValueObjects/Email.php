<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class Email 
    {
        /**
         * @var string
         */
        private $email;

        /**
         * @param string $email
         *
         * @throws \InvalidArgumentException
         */
        public function __construct($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException('"'. $email . '" is not a valid email');
            }

            $this->email = strtolower($email);
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->email;
        }
    }
}
