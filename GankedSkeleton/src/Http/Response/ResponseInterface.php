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

    interface ResponseInterface
    {
        /**
         * @param StatusCodeInterface $code
         */
        public function setStatusCode(StatusCodeInterface $code);

        /**
         * @param Cookie $cookie
         */
        public function setCookie(Cookie $cookie);

        /**
         * @param string $key
         * @param string $value
         */
        public function setHeader($key, $value);

        /**
         * @return array
         */
        public function getHeaders();

        /**
         * @return array
         */
        public function getCookies();

        /**
         * @param string $body
         */
        public function setBody($body);

        /**
         * @param RedirectInterface $redirect
         */
        public function setRedirect(RedirectInterface $redirect);

        /**
         * @return string
         */
        public function getBody();

        public function send();
    }
}
