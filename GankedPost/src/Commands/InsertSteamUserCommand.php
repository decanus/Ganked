<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Post\Commands
{

    use Ganked\Library\Gateways\GankedApiGateway;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\Username;

    class InsertSteamUserCommand
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
         * @param Email    $email
         * @param Username $username
         * @param SteamId  $steamId
         * @param          $verificationHash
         * @param string   $customId
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function execute(Email $email, Username $username, SteamId $steamId, $verificationHash, $customId = '')
        {

            $user = [
                'username' => (string) $username,
                'email' => (string) $email,
                'hash' => $verificationHash,
                'steamId' => $steamId,
                'steamName' => $customId,
            ];

            return $this->gankedApiGateway->createNewUser($user);
        }
    }
}
