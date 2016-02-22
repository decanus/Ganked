<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{
    /**
     * @covers Ganked\Backend\Factories\LocatorFactory
     * @uses \Ganked\Backend\Locators\TaskLocator
     * @uses \Ganked\Backend\Locators\RendererLocator
     */
    class LocatorFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createTaskLocator', \Ganked\Backend\Locators\TaskLocator::class],
                ['createRendererLocator', \Ganked\Backend\Locators\RendererLocator::class],
            ];
        }
    }
}
