<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Writers
{

    use Ganked\Library\Backends\MongoDatabaseBackend;

    class LeagueOfLegendsLeaderboardWriter
    {
        /**
         * @var MongoDatabaseBackend
         */
        private $mongoDatabaseBackend;

        /**
         * @param MongoDatabaseBackend $mongoDatabaseBackend
         */
        public function __construct(MongoDatabaseBackend $mongoDatabaseBackend)
        {
            $this->mongoDatabaseBackend = $mongoDatabaseBackend;
        }

        /**
         * @param array $entries
         *
         * @return array|bool
         */
        public function write(array $entries)
        {
            return $this->mongoDatabaseBackend->batchInsertIntoCollection($entries, 'leaderboards');
        }
    }
}
