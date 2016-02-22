<?php

/**
 * Copyright (c) Ganked <feedback@ganked.net>
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class StatisticNumber
    {
        /**
         * @var float
         */
        private $number;

        /**
         * @param number $number
         *
         * @throws \InvalidArgumentException
         */
        public function __construct($number)
        {
            if (!is_float($number) && !is_int($number)) {
                throw new \InvalidArgumentException($number . ' is not a valid number');
            }

            $this->number = $number;
        }

        /**
         * @return string
         */
        public function getRounded()
        {
            if ($this->number < 1000) {
                return (string) $this->number;
            }

            return round($this->number / 1000, 1) . ' K';
        }

        /**
         * @return string
         */
        public function getSeparatedThousands()
        {
            return number_format($this->number, 0, '', '\'');
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return (string) $this->number;
        }
    }
}
