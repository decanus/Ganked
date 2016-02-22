<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class LocatorFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Frontend\Locators\RendererLocator
         */
        public function createRendererLocator()
        {
            return new \Ganked\Frontend\Locators\RendererLocator($this->getMasterFactory());
        }
    }
}
