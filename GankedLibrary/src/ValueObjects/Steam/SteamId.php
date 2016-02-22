<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\ValueObjects\Steam
{

    class SteamId
    {
        /**
         * @var string
         */
        private $steamId;

        /**
         * @param string $steamId
         */
        public function __construct($steamId)
        {
            if (!is_numeric($steamId)) {
                throw new \InvalidArgumentException('"' . $steamId . '" is not a valid Steam64 Id');
            }

            $this->steamId = $steamId;
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->steamId;
        }
    }
}
