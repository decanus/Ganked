<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class QueryFactory extends AbstractFactory
    {

        /**
         * @return \Ganked\Fetch\Queries\FetchTwitchTopStreamsQuery
         */
        public function createFetchTwitchTopStreamsQuery()
        {
            return new \Ganked\Fetch\Queries\FetchTwitchTopStreamsQuery(
                $this->getMasterFactory()->createTwitchGateway()
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\GetDomFromFileQuery
         */
        public function createGetDomFromFileQuery()
        {
            return new \Ganked\Skeleton\Queries\GetDomFromFileQuery(
                $this->getMasterFactory()->createFileBackend()
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\FetchMatchForRegionQuery
         */
        public function createFetchMatchForRegionQuery()
        {
            return new \Ganked\Skeleton\Queries\FetchMatchForRegionQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }
    }
}
