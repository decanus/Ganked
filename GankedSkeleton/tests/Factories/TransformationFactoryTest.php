<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{

    /**
     * @covers Ganked\Skeleton\Factories\TransformationFactory
     * @uses Ganked\Skeleton\Factories\QueryFactory
     * @uses Ganked\Skeleton\Factories\CommandFactory
     * @uses Ganked\Skeleton\Factories\AbstractFactory
     * @uses Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     */
    class TransformationFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createSnippetTransformation', \Ganked\Skeleton\Transformations\SnippetTransformation::class],
                ['createTextTransformation', \Ganked\Skeleton\Transformations\TextTransformation::class]
            ];
        }
    }
}
