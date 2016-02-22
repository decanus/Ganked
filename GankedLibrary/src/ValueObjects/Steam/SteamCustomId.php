<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\ValueObjects\Steam
{

    class SteamCustomId
    {
        /**
         * @var string
         */
        private $customId;

        /**
         * @param string $customId
         */
        public function __construct($customId)
        {
            $length = strlen($customId);

            if ($length  < 2 || $length > 32) {
                throw new \InvalidArgumentException('"' . $customId . '" is not a valid custom steam id');
            }

            $this->customId = $customId;
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->customId;
        }
    }
}
