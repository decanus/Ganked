<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Backends\Stream
{

    use Ganked\Skeleton\Backends\Streams\AbstractStreamWrapper;

    class PagesStreamWrapper extends AbstractStreamWrapper
    {
        /**
         * @var string
         */
        protected static $protocol = 'pages';

        /**
         * @var string
         */
        protected static $path;
    }
}
