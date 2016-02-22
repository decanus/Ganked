<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class MapperFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Fetch\Mappers\LandingPageStreamMapper
         */
        public function createLandingPageStreamMapper()
        {
            return new \Ganked\Fetch\Mappers\LandingPageStreamMapper();
        }
    }
}
