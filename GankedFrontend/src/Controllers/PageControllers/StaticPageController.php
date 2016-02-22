<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Models\StaticPageModel;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Library\DataPool\DataPoolReader;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Http\StatusCodes\NotFound;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class StaticPageController extends AbstractPageController
    {
        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        /**
         * @param AbstractResponse        $response
         * @param FetchSessionCookieQuery $fetchSessionCookieQuery
         * @param AbstractPageRenderer    $renderer
         * @param AbstractPageModel       $model
         * @param WriteSessionCommand     $writeSessionCommand
         * @param StorePreviousUriCommand $storePreviousUriCommand
         * @param IsSessionStartedQuery   $isSessionStartedQuery
         * @param DataPoolReader          $dataPoolReader
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            AbstractPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            DataPoolReader $dataPoolReader
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

            $this->dataPoolReader = $dataPoolReader;
        }

        protected function doRun()
        {
            /**
             * @var $model StaticPageModel
             */
            $model = $this->getModel();
            $path = $model->getRequestUri()->getPath();

            if ($path === '/404') {
                $this->getResponse()->setStatusCode(new NotFound);
            }

            $model->setMetaTags($this->dataPoolReader->getMetaTagsForStaticPage($path));
            $model->setTemplate($this->dataPoolReader->getStaticPageSnippet($path));
            $model->setBodyClass($this->dataPoolReader->getBodyClassForStaticPage($path));
        }
    }
}
