<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class LocatorFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Backend\Locators\TaskLocator
         */
        public function createTaskLocator()
        {
            return new \Ganked\Backend\Locators\TaskLocator($this->getMasterFactory());
        }

        /**
         * @return \Ganked\Backend\Locators\RendererLocator
         */
        public function createRendererLocator()
        {
            return new \Ganked\Backend\Locators\RendererLocator($this->getMasterFactory());
        }
    }
}
