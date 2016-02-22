<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Models
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Http\Redirect\AbstractRedirect;

    abstract class AbstractModel
    {
        /**
         * @var Uri
         */
        private $requestUri;

        /**
         * @var Uri
         */
        private $redirectUri;

        /**
         * @var AbstractRedirect
         */
        private $redirect;

        /**
         * @param Uri $requestUri
         */
        public function __construct(Uri $requestUri)
        {
            $this->requestUri = $requestUri;
        }

        /**
         * @return Uri
         */
        public function getRequestUri()
        {
            return $this->requestUri;
        }

        /**
         * @param Uri $redirectUri
         */
        public function setRedirectUri(Uri $redirectUri)
        {
            $this->redirectUri = $redirectUri;
        }

        /**
         * @return Uri
         */
        public function getRedirectUri()
        {
            return $this->redirectUri;
        }

        /**
         * @return bool
         */
        public function hasRedirectUri()
        {
            return $this->redirectUri instanceof \Ganked\Library\ValueObjects\Uri;
        }

        /**
         * @param AbstractRedirect $redirect
         */
        public function setRedirect(AbstractRedirect $redirect)
        {
            $this->redirect = $redirect;
        }

        /**
         * @return AbstractRedirect
         * @throws \RuntimeException
         */
        public function getRedirect()
        {
            if (!$this->hasRedirect()) {
                throw new \RuntimeException('No redirect defined');
            }

            return $this->redirect;
        }

        /**
         * @return bool
         */
        public function hasRedirect()
        {
            return $this->redirect instanceof AbstractRedirect;
        }

    }
}
