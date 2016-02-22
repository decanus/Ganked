<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Readers
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\Steam\SteamCustomId;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Skeleton\Gateways\CounterStrikeGateway;

    class CounterStrikeReader
    {
        /**
         * @var CounterStrikeGateway
         */
        private $gateway;

        /**
         * @param CounterStrikeGateway $gateway
         */
        public function __construct(CounterStrikeGateway $gateway)
        {
            $this->gateway = $gateway;
        }

        /**
         * @param SteamId $steamId
         *
         * @return bool
         */
        public function hasSteamUserWithId(SteamId $steamId)
        {
            $data = json_decode($this->gateway->getSteamUserInfoById((string) $steamId)->getBody(), true);
            return isset($data['response']['players']) && !empty($data['response']['players']);
        }

        /**
         * @param SteamCustomId $customId
         *
         * @return bool
         */
        public function hasSteamUserWithCustomId(SteamCustomId $customId)
        {
            return (new DomHelper($this->gateway->getSteamUserById((string) $customId)->getBody()))->query('//error')->length === 0;
        }
    }
}
