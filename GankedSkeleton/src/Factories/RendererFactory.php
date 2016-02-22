<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{
    class RendererFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Skeleton\Renderers\XslRenderer
         */
        public function createXslRenderer()
        {
            return new \Ganked\Skeleton\Renderers\XslRenderer($this->getMasterFactory()->createDomBackend());
        }
    }
}
