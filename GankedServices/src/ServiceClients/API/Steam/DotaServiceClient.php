<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\ServiceClients\API
{

    use Ganked\Library\ValueObjects\Uri;

    class DotaServiceClient extends AbstractSteamServiceClient
    {

        /**
         * @return string
         */
        public function getNewsForApp()
        {
            return $this->sendGetRequest(new Uri('http://blog.dota2.com/feed/'), [], [], 3600)->getRawResponseBody();
        }
    }
}
