<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    use Ganked\Skeleton\Factories\AbstractFactory;

    class ReaderFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\API\Readers\TokenReader
         */
        public function createTokenReader()
        {
            return new \Ganked\API\Readers\TokenReader($this->getMasterFactory()->createFileBackend());
        }
    }
}
