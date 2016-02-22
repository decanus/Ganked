<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class Token 
    {
        /**
         * @var string
         */
        private $tokenValue;

        /**
         * @param string $token
         */
        public function __construct($token = null)
        {
            if ($token !== null) {
                $this->tokenValue = $token;
            } else {
                $this->tokenValue = $this->generateToken();
            }
        }

        /**
         * @param string $token
         *
         * @return bool
         */
        public function check($token)
        {
            return $this->tokenValue === (string) $token;
        }

        /**
         * @return string
         */
        private function generateToken()
        {
            return base64_encode(openssl_random_pseudo_bytes(32));
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->tokenValue;
        }
    }
}
