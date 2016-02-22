<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\ServiceClients\API
{

    use Ganked\Library\ValueObjects\Uri;

    class CounterStrikeServiceClient extends AbstractSteamServiceClient
    {
        /**
         * @return string
         */
        public function getNewsForApp()
        {
            return $this->sendGetRequest(new Uri('http://blog.counter-strike.net/index.php/feed/'), [], [], 3600)->getRawResponseBody();
        }
    }
}
