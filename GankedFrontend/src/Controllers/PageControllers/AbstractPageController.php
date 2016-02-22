<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    abstract class AbstractPageController extends \Ganked\Skeleton\Controllers\AbstractPageController
    {
        /**
         * @var AbstractPageRenderer
         */
        private $renderer;

        /**
         * @var AbstractPageModel
         */
        private $model;

        /**
         * @var WriteSessionCommand
         */
        private $writeSessionCommand;

        /**
         * @var StorePreviousUriCommand
         */
        private $storePreviousUriCommand;

        /**
         * @var string
         */
        private $body;

        /**
         * @var FetchSessionCookieQuery
         */
        private $fetchSessionCookieQuery;

        /**
         * @var IsSessionStartedQuery
         */
        private $isSessionStartedQuery;

        /**
         * @param AbstractResponse $response
         * @param FetchSessionCookieQuery $fetchSessionCookieQuery
         * @param AbstractPageRenderer $renderer
         * @param AbstractPageModel $model
         * @param WriteSessionCommand $writeSessionCommand
         * @param StorePreviousUriCommand $storePreviousUriCommand
         * @param IsSessionStartedQuery $isSessionStartedQuery
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            AbstractPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery
        )
        {
            parent::__construct($response);
            $this->fetchSessionCookieQuery = $fetchSessionCookieQuery;
            $this->renderer = $renderer;
            $this->model = $model;
            $this->storePreviousUriCommand = $storePreviousUriCommand;
            $this->writeSessionCommand = $writeSessionCommand;
            $this->isSessionStartedQuery = $isSessionStartedQuery;
        }

        protected function run()
        {
            $uri = $this->getRequest()->getUri();
            $path = $uri->getPath();

            if ($path !== '/login' && $path !== '/recover-password' && $path !== '/login/steam' && $path !== '/register/steam') {
                $this->storePreviousUriCommand->execute($uri);
            }

            $this->doRun();

            if ($this->getModel()->hasRedirect()) {
                $this->getResponse()->setRedirect($this->getModel()->getRedirect());
            } else {
                $this->body = $this->getRenderer()->render($this->getModel());
            }

            $this->setResponseCode($this->model->getResponseCode());

            if (!$this->isSessionStartedQuery->execute()) {
                $this->getResponse()->setCookie($this->fetchSessionCookieQuery->execute());
            }

            $this->writeSessionCommand->execute();
        }

        /**
         * @return AbstractPageRenderer
         */
        protected function getRenderer()
        {
            return $this->renderer;
        }

        /**
         * @return AbstractPageModel
         */
        protected function getModel()
        {
            return $this->model;
        }

        /**
         * @return string
         */
        protected function getRendererResultBody()
        {
            return $this->body;
        }

        abstract protected function doRun();
    }
}
