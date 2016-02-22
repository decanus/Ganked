<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\ParameterObjects
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Http\Redirect\AbstractRedirect;

    class RedirectControllerParameterObject extends AbstractControllerParameterObject
    {
        /**
         * @var AbstractRedirect
         */
        private $redirect;

        /**
         * @param Uri              $uri
         * @param AbstractRedirect $redirect
         */
        public function __construct(Uri $uri, AbstractRedirect $redirect)
        {
            parent::__construct($uri);
            $this->redirect = $redirect;
        }

        /**
         * @return AbstractRedirect
         */
        public function getRedirect()
        {
            return $this->redirect;
        }
    }
}
