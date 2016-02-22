<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Redirect
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Post\Handlers\AbstractHandler;

    abstract class AbstractRedirectHandler extends AbstractHandler
    {
        /**
         * @var bool
         */
        private $isDevelopment;

        /**
         * @param bool $isDevelopment
         */
        public function __construct($isDevelopment = false)
        {
            $this->isDevelopment = $isDevelopment;
        }

        /**
         * @param string $path
         *
         * @return Uri
         */
        protected function redirectToPath($path = '/')
        {
            if ($this->isDevelopment) {
                return new Uri('http://dev.ganked.net' . $path);
            }

            return new Uri('http://www.ganked.net' . $path);
        }
    }
}
