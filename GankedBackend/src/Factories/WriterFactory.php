<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class WriterFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Backend\Writers\LeagueOfLegendsLeaderboardWriter
         */
        public function createLeagueOfLegendsLeaderboardWriter()
        {
            return new \Ganked\Backend\Writers\LeagueOfLegendsLeaderboardWriter(
                $this->getMasterFactory()->createMongoDatabaseBackend()
            );
        }

        /**
         * @return \Ganked\Backend\Writers\StaticPageWriter
         */
        public function createStaticPageWriter()
        {
            return new \Ganked\Backend\Writers\StaticPageWriter(
                $this->getMasterFactory()->createRedisBackend()
            );
        }

        /**
         * @return \Ganked\Library\DataPool\LeagueOfLegendsDataPoolWriter
         */
        public function createLeagueOfLegendsDataPoolWriter()
        {
            return new \Ganked\Library\DataPool\LeagueOfLegendsDataPoolWriter(
                $this->getMasterFactory()->createRedisBackend()
            );
        }
    }
}
