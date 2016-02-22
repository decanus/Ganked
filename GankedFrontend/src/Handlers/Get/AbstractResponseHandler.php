<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Handlers\Get
{

    use Ganked\Skeleton\Handlers\ResponseHandlerInterface;
    use Ganked\Skeleton\Http\Response\ResponseInterface;
    use Ganked\Skeleton\Models\AbstractModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    abstract class AbstractResponseHandler implements ResponseHandlerInterface
    {
        /**
         * @var ResponseInterface
         */
        private $response;

        /**
         * @var AbstractModel
         */
        private $model;

        /**
         * @var IsSessionStartedQuery
         */
        private $isSessionStartedQuery;

        /**
         * @var FetchSessionCookieQuery
         */
        private $fetchSessionCookieQuery;

        /**
         * @param IsSessionStartedQuery   $isSessionStartedQuery
         * @param FetchSessionCookieQuery $fetchSessionCookieQuery
         */
        public function __construct(
            IsSessionStartedQuery $isSessionStartedQuery,
            FetchSessionCookieQuery $fetchSessionCookieQuery
        )
        {
            $this->isSessionStartedQuery = $isSessionStartedQuery;
            $this->fetchSessionCookieQuery = $fetchSessionCookieQuery;
        }

        /**
         * @param ResponseInterface $responseInterface
         * @param AbstractModel     $model
         */
        public function execute(ResponseInterface $responseInterface, AbstractModel $model)
        {
            $this->response = $responseInterface;
            $this->model = $model;

            $this->doExecute();

            if ($model->hasRedirect()) {
                $responseInterface->setRedirect($model->getRedirect());
            }

            if (!$this->isSessionStartedQuery->execute()) {
                $this->getResponse()->setCookie($this->fetchSessionCookieQuery->execute());
            }
        }

        abstract protected function doExecute();

        /**
         * @return ResponseInterface
         */
        protected function getResponse()
        {
            return $this->response;
        }

        /**
         * @return AbstractModel
         */
        protected function getModel()
        {
            return $this->model;
        }
    }
}
