<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Handlers\AbstractSearchHandler;
    use Ganked\Frontend\Models\SearchPageModel;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class SearchPageController extends AbstractPageController
    {
        /**
         * @var AbstractSearchHandler
         */
        private $searchHandler;

        /**
         * @param AbstractResponse $response
         * @param FetchSessionCookieQuery $fetchSessionCookieQuery
         * @param AbstractPageRenderer $renderer
         * @param SearchPageModel $model
         * @param WriteSessionCommand $writeSessionCommand
         * @param StorePreviousUriCommand $storePreviousUriCommand
         * @param IsSessionStartedQuery $isSessionStartedQuery
         * @param AbstractSearchHandler $searchHandler
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            SearchPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            AbstractSearchHandler $searchHandler
        )
        {
            parent::__construct(
                $response,
                $fetchSessionCookieQuery,
                $renderer,
                $model,
                $writeSessionCommand,
                $storePreviousUriCommand,
                $isSessionStartedQuery
            );

            $this->searchHandler = $searchHandler;
        }

        protected function doRun()
        {
            $this->searchHandler->run($this->getModel());

            if ($this->getModel()->hasRedirect()) {
                $this->getResponse()->setRedirect($this->getModel()->getRedirect());
            }
        }
    }
}
