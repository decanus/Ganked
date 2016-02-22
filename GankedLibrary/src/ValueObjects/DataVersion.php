<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    class DataVersion 
    {
        /**
         * @var string
         */
        private $dataVersion;

        /**
         * @param string $dataVersion
         *
         * @throws \InvalidArgumentException
         */
        public function __construct($dataVersion)
        {
            if ($dataVersion === 'now') {
                $dataVersion = (new \DateTime($dataVersion))->format('Ymd-Hi');
            }

            $this->validateVersion($dataVersion);

            $this->dataVersion = $dataVersion;

        }

        /**
         * @param string $version
         *
         * @throws \InvalidArgumentException
         */
        private function validateVersion($version)
        {
            if (\DateTime::createFromFormat('Ymd-Hi', $version) === false) {
                throw new \InvalidArgumentException('Invalid version format "' . $version . '"');
            }
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->dataVersion;
        }
    }
}
