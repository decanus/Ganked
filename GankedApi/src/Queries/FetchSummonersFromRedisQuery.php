<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Queries
{

    use Ganked\Library\DataPool\DataPoolReader;

    class FetchSummonersFromRedisQuery
    {
        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        /**
         * @param DataPoolReader $dataPoolReader
         */
        public function __construct(DataPoolReader $dataPoolReader)
        {
            $this->dataPoolReader = $dataPoolReader;
        }

        /**
         * @param array $summoners
         *
         * @return array
         */
        public function execute(array $summoners = [])
        {
            return $this->dataPoolReader->getSummonersFromHash($summoners);
        }
    }
}
