<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Http\Response
{

    use Ganked\Library\ValueObjects\Cookie;
    use Ganked\Skeleton\Http\Redirect\RedirectInterface;
    use Ganked\Skeleton\Http\StatusCodes\StatusCodeInterface;

    abstract class AbstractResponse implements ResponseInterface
    {
        /**
         * @var StatusCodeInterface
         */
        private $statusCode;

        /**
         * @var array
         */
        private $cookies = [];

        /**
         * @var array
         */
        private $headers = [];

        /**
         * @var string
         */
        private $body;

        /**
         * @var RedirectInterface
         */
        private $redirect = null;

        /**
         * @param RedirectInterface $redirect
         */
        public function setRedirect(RedirectInterface $redirect)
        {
            $this->redirect = $redirect;
        }

        /**
         * @param StatusCodeInterface $code
         */
        public function setStatusCode(StatusCodeInterface $code)
        {
            $this->statusCode = $code;
        }

        /**
         * @param Cookie $cookie
         */
        public function setCookie(Cookie $cookie)
        {
            $this->cookies[] = $cookie;
        }

        /**
         * @return array
         */
        public function getCookies()
        {
            return $this->cookies;
        }

        /**
         * @param string $key
         * @param string $value
         *
         * @deprecated for Redirect
         */
        public function setHeader($key, $value)
        {
            $this->headers[$key] = $value;
        }

        /**
         * @return array
         */
        public function getHeaders()
        {
            return $this->headers;
        }

        /**
         * @param string $body
         */
        public function setBody($body)
        {
            $this->body = $body;
        }

        /**
         * @return string
         */
        public function getBody()
        {
            return $this->body;
        }

        /**
         * @codeCoverageIgnore
         */
        public function send()
        {
            $this->setMimeType();

            if ($this->statusCode instanceof StatusCodeInterface) {
                header($this->statusCode->getHeaderString(), true, (string) $this->statusCode);
            }

            foreach ($this->getHeaders() as $header => $value) {
                header($header . ':' . $value);
            }

            if ($this->redirect instanceof RedirectInterface) {
                header('Location:' . $this->redirect->getUri(), true, (string) $this->redirect->getStatusCode());
            }

            /**
             * @var $cookie Cookie
             */
            foreach ($this->cookies as $cookie) {
                setcookie(
                    $cookie->getName(),
                    $cookie->getValue(),
                    $cookie->getExpires(),
                    $cookie->getPath(),
                    $cookie->getDomain(),
                    $cookie->isSecure(),
                    $cookie->isHttpOnly()
                );
            }

            echo $this->body;
        }

        abstract protected function setMimeType();
    }
}
