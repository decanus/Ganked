<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Post\Commands
{

    use Ganked\Library\Gateways\GankedApiGateway;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\UserId;

    class ConnectSteamAccountToUserCommand
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
         * @param UserId  $userId
         * @param SteamId $steamId
         * @param string  $name
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function execute(UserId $userId, SteamId $steamId, $name = '')
        {
            return $this->gankedApiGateway->connectSteamAccountToUser($userId, $steamId, $name);
        }
    }
}
