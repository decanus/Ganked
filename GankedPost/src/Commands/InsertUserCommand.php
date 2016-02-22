<?php

/**
* Copyright (c) Ganked 2015
* All rights reserved.
*/

namespace Ganked\Post\Commands
{

    use Ganked\Library\Gateways\GankedApiGateway;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\FirstName;
    use Ganked\Library\ValueObjects\Hash;
    use Ganked\Library\ValueObjects\LastName;
    use Ganked\Library\ValueObjects\Salt;
    use Ganked\Library\ValueObjects\Username;

    class InsertUserCommand
    {
        /**
         * @var GankedApiGateway
         */
        private $gankedApiGateway;

        /**
         * @param GankedApiGateway $gankedApiGateway
         */
        public function __construct(GankedApiGateway $gankedApiGateway)
        {
            $this->gankedApiGateway = $gankedApiGateway;
        }

        /**
         * @param FirstName $firstName
         * @param LastName  $lastName
         * @param Username  $username
         * @param Hash      $hash
         * @param Salt      $salt
         * @param Email     $email
         * @param string    $verificationHash
         * @return \Ganked\Skeleton\Backends\Wrappers\CurlResponse
         */
        public function execute(
            FirstName $firstName,
            LastName $lastName,
            Username $username,
            Hash $hash,
            Salt $salt,
            Email $email,
            $verificationHash
        )
        {
            $user = [
                'firstname' => (string) $firstName,
                'lastname' => (string) $lastName,
                'username' => (string) $username,
                'password' => (string) $hash,
                'salt' => (string) $salt,
                'email' => (string) $email,
                'hash' => $verificationHash,
            ];

            return $this->gankedApiGateway->createNewUser($user);
        }
    }
}
