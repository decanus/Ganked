<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Fetch\Factories
{

    use Ganked\Skeleton\Http\Response\JsonResponse;

    class ControllerFactory extends \Ganked\Skeleton\Factories\ControllerFactory
    {
        /**
         * @return \Ganked\Fetch\Controllers\DataFetchController
         */
        public function createLandingPageStreamController()
        {
            return new \Ganked\Fetch\Controllers\DataFetchController(
                new JsonResponse,
                $this->getMasterFactory()->createLandingPageStreamDataFetchHandler()
            );
        }

        /**
         * @return \Ganked\Fetch\Controllers\DataFetchController
         */
        public function createFetchMatchController()
        {
            return new \Ganked\Fetch\Controllers\DataFetchController(
                new JsonResponse,
                $this->getMasterFactory()->createLeagueOfLegendsMatchDataFetchHandler()
            );
        }
    }
}
