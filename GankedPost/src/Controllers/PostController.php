<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Controllers
{

    use Ganked\Post\Handlers\HandlerInterface;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Redirect\RedirectToUri;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;
    use Ganked\Skeleton\Models\AbstractModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class PostController extends AbstractPageController
    {

        /**
         * @var HandlerInterface
         */
        private $handler;

        /**
         * @var string
         */
        private $result;

        /**
         * @var AbstractModel
         */
        private $model;

        /**
         * @var WriteSessionCommand
         */
        private $writeSessionCommand;

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
         * @param HandlerInterface $handler
         * @param AbstractModel $model
         * @param WriteSessionCommand $writeSessionCommand
         * @param IsSessionStartedQuery $isSessionStartedQuery
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            HandlerInterface $handler,
            AbstractModel $model,
            WriteSessionCommand $writeSessionCommand,
            IsSessionStartedQuery $isSessionStartedQuery
        )
        {
            parent::__construct($response);
            $this->fetchSessionCookieQuery = $fetchSessionCookieQuery;
            $this->handler = $handler;
            $this->model = $model;
            $this->writeSessionCommand = $writeSessionCommand;
            $this->isSessionStartedQuery = $isSessionStartedQuery;
        }

        protected function run()
        {
            $this->result = $this->handler->execute($this->model, $this->getRequest());

            if ($this->model->hasRedirectUri()) {
                $this->getResponse()->setRedirect(new RedirectToUri($this->model->getRedirectUri(), new MovedTemporarily));
            }

            if ($this->model->hasRedirect()) {
                $this->getResponse()->setRedirect($this->model->getRedirect());
            }

            $this->writeSessionCommand->execute();
            if (!$this->isSessionStartedQuery->execute()) {
                $this->getResponse()->setCookie($this->fetchSessionCookieQuery->execute());
            }
        }

        /**
         * @return string
         */
        protected function getRendererResultBody()
        {
            return json_encode($this->result);
        }
    }
}
