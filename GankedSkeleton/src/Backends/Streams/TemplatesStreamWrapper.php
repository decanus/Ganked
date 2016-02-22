<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Backends\Streams
{
    class TemplatesStreamWrapper extends AbstractStreamWrapper
    {
        /**
         * @var string
         */
        protected static $protocol = 'templates';

        /**
         * @var string
         */
        protected static $path;
    }
}
