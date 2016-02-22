<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Controllers
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Http\Request\RequestInterface;
    use Ganked\Skeleton\Http\Response\ResponseInterface;

    /**
     * @deprecated
     */
    abstract class AbstractPageController implements ControllerInterface
    {
        /**
         * @var RequestInterface
         */
        private $request;

        /**
         * @var Uri
         */
        private $redirect;

        /**
         * @var ResponseInterface
         */
        private $response;

        /**
         * @var int
         */
        private $responseCode;

        /**
         * @param ResponseInterface $response
         */
        public function __construct(ResponseInterface $response)
        {
            $this->response = $response;
        }

        /**
         * @param RequestInterface $request
         *
         * @return ResponseInterface
         */
        public function execute(RequestInterface $request)
        {
            $this->request = $request;
            $this->run();

            if ($this->redirect !== null) {
                $this->response->setHeader('Location', $this->redirect);
            } else {
                $this->response->setBody($this->getRendererResultBody());
            }

            return $this->response;
        }

        /**
         * @return ResponseInterface
         */
        protected function getResponse()
        {
            return $this->response;
        }

        /**
         * @param Uri $uri
         */
        protected function setRedirect(Uri $uri)
        {
            $this->redirect = $uri;
        }

        /**
         * @param int $responseCode
         */
        protected function setResponseCode($responseCode)
        {
            $this->responseCode = $responseCode;
        }

        /**
         * @return RequestInterface
         */
        protected function getRequest()
        {
            return $this->request;
        }

        abstract protected function run();
        abstract protected function getRendererResultBody();
    }
}
