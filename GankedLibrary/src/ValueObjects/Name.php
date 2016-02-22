<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class Name 
    {
        /**
         * @var string
         */
        private $name;

        /**
         * @param string $name
         *
         * @throws \InvalidArgumentException
         */
        public function __construct($name)
        {
            if (!preg_match('/^[\pL\pM]+$/u', $name)) {
                throw new \InvalidArgumentException('Invalid name');
            }

            $this->name = ucfirst(strtolower($name));
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->name;
        }
    }
}
