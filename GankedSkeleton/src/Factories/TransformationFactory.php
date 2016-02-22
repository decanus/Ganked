<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{
    class TransformationFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Skeleton\Transformations\SnippetTransformation
         */
        public function createSnippetTransformation()
        {
            return new \Ganked\Skeleton\Transformations\SnippetTransformation;
        }

        /**
         * @return \Ganked\Skeleton\Transformations\TextTransformation
         */
        public function createTextTransformation()
        {
            return new \Ganked\Skeleton\Transformations\TextTransformation;
        }
    }
}
