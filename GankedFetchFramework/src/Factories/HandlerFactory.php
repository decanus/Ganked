<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Fetch\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class HandlerFactory extends AbstractFactory
    {

        /**
         * @return \Ganked\Fetch\Handlers\DataFetch\LandingPageStreamDataFetchHandler
         */
        public function createLandingPageStreamDataFetchHandler()
        {
            return new \Ganked\Fetch\Handlers\DataFetch\LandingPageStreamDataFetchHandler(
                $this->getMasterFactory()->createFetchTwitchTopStreamsQuery(),
                $this->getMasterFactory()->createLandingPageStreamMapper()
            );
        }

        /**
         * @return \Ganked\Fetch\Handlers\DataFetch\LeagueOfLegendsMatchDataFetchHandler
         */
        public function createLeagueOfLegendsMatchDataFetchHandler()
        {
            return new \Ganked\Fetch\Handlers\DataFetch\LeagueOfLegendsMatchDataFetchHandler(
                $this->getMasterFactory()->createFetchMatchForRegionQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader(),
                $this->getMasterFactory()->createImageUriGenerator()
            );
        }
    }
}
