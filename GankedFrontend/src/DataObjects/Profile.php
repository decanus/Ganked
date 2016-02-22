<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\DataObjects
{

    use Ganked\Library\ValueObjects\Username;

    class Profile
    {
        /**
         * @var Username
         */
        private $username;

        /**
         * @param Username $username
         */
        public function setUsername(Username $username)
        {
            $this->username = $username;
        }

        /**
         * @return Username
         */
        public function getUsername()
        {
            return $this->username;
        }
    }
}
