<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\ValueObjects
{

    class KDA
    {
        /**
         * @var int
         */
        private $kda;

        /**
         * @param int $kills
         * @param int $deaths
         * @param int $assists
         *
         * @throws \InvalidArgumentException
         */
        public function __construct($kills, $deaths, $assists)
        {
            $this->kda = $this->calculateNumber($kills, $deaths, $assists);
        }

        /**
         * @param int $kills
         * @param int $deaths
         * @param int $assists
         *
         * @return float|int
         */
        private function calculateNumber($kills, $deaths, $assists)
        {
            $ka = $kills + $assists;

            if ($deaths === 0 || $deaths === '0') {
                return $ka;
            }

            return round($ka / $deaths, 1);
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return (string) $this->kda;
        }
    }
}
