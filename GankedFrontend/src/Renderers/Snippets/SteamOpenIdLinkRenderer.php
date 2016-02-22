<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\Uri;

    class SteamOpenIdLinkRenderer
    {
        /**
         * @var \LightOpenID
         */
        private $openID;

        /**
         * @var Uri
         */
        private $returnUrl;

        /**
         * @param \LightOpenID $openID
         * @param Uri          $returnUrl
         */
        public function __construct(\LightOpenID $openID, Uri $returnUrl)
        {
            $this->openID = $openID;
            $this->returnUrl = $returnUrl;
        }

        /**
         * @param string $text
         * @param string $returnPath
         *
         * @return DomHelper
         */
        public function render($text = 'Sign in through steam', $returnPath = '/login/steam')
        {
            try {
                $this->openID->identity = 'http://steamcommunity.com/openid';
                $this->openID->returnUrl = $this->returnUrl . $returnPath;

                $href = $this->openID->authUrl() . '&openid.return_to=' . $this->returnUrl . $returnPath;
            } catch (\Exception $e) {
                $href = '/login';
            }

            return new DomHelper('<a href="' . htmlspecialchars($href)  . '" rel="nofollow">' . $text . '</a>');
        }
    }
}
