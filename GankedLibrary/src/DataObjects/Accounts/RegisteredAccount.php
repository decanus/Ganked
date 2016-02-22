<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\DataObjects\Accounts
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;

    class RegisteredAccount implements AccountInterface, \JsonSerializable
    {
        /**
         * @var UserId
         */
        private $id;

        /**
         * @var Email
         */
        private $email;

        /**
         * @var Username
         */
        private $username;

        /**
         * @param UserId   $id
         * @param Email    $email
         * @param Username $username
         */
        public function __construct(UserId $id, Email $email, Username $username)
        {
            $this->id = $id;
            $this->email = $email;
            $this->username = $username;
        }

        /**
         * @return UserId
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return Email
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * @return Username
         */
        public function getUsername()
        {
            return $this->username;
        }

        /**
         * @return array
         */
        public function jsonSerialize()
        {
            return [
                'id' => (string) $this->getId(),
                'email' => (string) $this->getEmail(),
                'username' => (string) $this->getUsername(),
            ];
        }
    }
}
