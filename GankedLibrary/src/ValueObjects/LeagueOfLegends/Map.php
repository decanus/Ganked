<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\ValueObjects
{

    class Map
    {
        /**
         * @var array
         */
        private $maps = [
            1  => 'summoners-rift',
            2  => 'summoners-rift',
            4  => 'twisted-treeline',
            8  => 'crystal-scar',
            10 => 'the-twisted-treeline',
            11 => 'summoners-rift',
            12 => 'howling-abyss',
            14 => 'butchers-bridge'
        ];

        /**
         * @var string
         */
        private $map;

        /**
         * @param int $map
         *
         * @throws \InvalidArgumentException
         */
        public function __construct($map)
        {
            if (!isset($this->maps[$map])) {
                throw new \InvalidArgumentException('Map "' . $map . '" is not a valid map!');
            }

            $this->map = $this->maps[$map];
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->map;
        }
    }
}
