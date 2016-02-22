<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class LastName extends Name
    {
        /**
         * @param string $name
         */
        public function __construct($name)
        {
            if (strlen($name) > 100) {
                throw new \InvalidArgumentException('Invalid last name');
            }

            parent::__construct($name);
        }
    }
}
