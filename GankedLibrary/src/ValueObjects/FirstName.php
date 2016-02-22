<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class FirstName extends Name
    {
        /**
         * @param string $name
         */
        public function __construct($name)
        {
            if (strlen($name) > 50) {
                throw new \InvalidArgumentException('Invalid first name');
            }

            parent::__construct($name);
        }
    }
}
