<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Models
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Skeleton\Models\AbstractPageModel;

    class PasswordRecoveryPageModel extends AbstractPageModel
    {
        /**
         * @var bool
         */
        private $isHashValid = false;

        /**
         * @var Email
         */
        private $email;

        /**
         * @var string
         */
        private $hash;

        /**
         * @return bool
         */
        public function isHashValid()
        {
            return $this->isHashValid;
        }

        public function hashIsInvalid()
        {
            $this->isHashValid = false;
        }

        public function hashIsValid()
        {
            $this->isHashValid = true;
        }

        /**
         * @param Email $email
         */
        public function setEmail(Email $email)
        {
            $this->email = $email;
        }

        /**
         * @return Email
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * @param string $hash
         */
        public function setHash($hash)
        {
            $this->hash = $hash;
        }

        /**
         * @return string
         */
        public function getHash()
        {
            return $this->hash;
        }
    }
}
