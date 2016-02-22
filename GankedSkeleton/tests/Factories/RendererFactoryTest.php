<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{

    /**
     * @covers Ganked\Skeleton\Factories\RendererFactory
     * @uses Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Skeleton\Factories\QueryFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Skeleton\Factories\AbstractFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Skeleton\Factories\CommandFactory
     * @uses \Ganked\Skeleton\Renderers\XslRenderer
     */
    class RendererFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createXslRenderer', \Ganked\Skeleton\Renderers\XslRenderer::class]
            ];
        }
    }
}
