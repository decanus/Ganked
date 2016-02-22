<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services\Backends
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Backends\Wrappers\Curl;

    class SlackBackend
    {
        /**
         * @var string
         */
        private $token;

        /**
         * @var Curl
         */
        private $curl;

        /**
         * @var Uri
         */
        private $uri;

        /**
         * @param $token
         * @param Curl $curl
         * @param Uri $uri
         */
        public function __construct($token, Curl $curl, Uri $uri)
        {
            $this->token = $token;
            $this->curl = $curl;
            $this->uri = $uri;
        }


        /**
         * @param string $channel
         * @param string $message
         */
        public function sendMessage($channel, $message)
        {
            $data = [
                'token' => $this->token,
                'channel' => $channel,
                'text' => $message,
                'username' => 'Ganked Bot',
                'icon_url' => 'http://www.ganked.net/html/favicon/android-chrome-192x192.png'
            ];

            $this->curl->get(new Uri((string) $this->uri . '/chat.postMessage'), $data)->execute();
        }
    }
}