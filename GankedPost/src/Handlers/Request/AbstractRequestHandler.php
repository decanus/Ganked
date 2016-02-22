<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Request
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Post\Handlers\AbstractHandler;
    use Ganked\Skeleton\Session\Session;

    abstract class AbstractRequestHandler extends AbstractHandler
    {
        /**
         * @var array
         */
        private $errors = [];

        /**
         * @var string
         */
        private $errorMessage = '';

        /**
         * @var array
         */
        private $success = [];

        /**
         * @var Session
         */
        private $session;

        /**
         * @param Session $session
         */
        public function __construct(Session $session)
        {
            $this->session = $session;
        }

        /**
         * @return array
         */
        protected function doExecute()
        {
            $this->validateForm();

            if ($this->errorMessage === '' && empty($this->errors)) {
                $this->performAction();
            }

            return $this->createResponse();
        }

        /**
         * @throws \Exception
         */
        protected function checkCSRFToken()
        {
            // Don't catch invalid CSRF deserves a 500 error page
            if (!$this->session->getToken()->check($this->getRequest()->getParameter('token'))) {
                throw new \RuntimeException('CSRF token does not match');
            }
        }

        /**
         * @return array
         */
        private function createResponse()
        {
            $message = ['status' => 'success', 'data' => $this->success];

            if (empty($this->errors) && empty($this->errorMessage)) {
                return $message;
            }

            unset($message['text']);
            $message['status'] = 'error';
            $message['data'] = $this->errors;

            if ($this->errorMessage !== '') {
                $message['error'] = $this->errorMessage;
            }

            return $message;
        }

        /**
         * @param string $key
         * @param string $value
         */
        protected function setError($key, $value)
        {
            $this->errors[$key] = ['text' => $value];
        }

        /**
         * @param Uri $uri
         */
        protected function setRedirect(Uri $uri)
        {
            $this->success['redirect'] = (string) $uri;
        }

        /**
         * @param string $message
         */
        protected function setSuccessMessage($message)
        {
            $this->success['text'] = $message;
        }

        /**
         * @param $message
         */
        protected function setErrorMessage($message)
        {
            $this->errorMessage = $message;
        }

        /**
         * @return \Ganked\Skeleton\Session\SessionData
         */
        protected function getSessionData()
        {
            return $this->session->getSessionData();
        }

        abstract protected function validateForm();
        abstract protected function performAction();
    }
}
