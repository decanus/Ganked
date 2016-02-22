<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Controllers
{

    use Ganked\Fetch\Handlers\DataFetch\DataFetchHandlerInterface;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Response\AbstractResponse;

    class DataFetchController extends AbstractPageController
    {
        /**
         * @var DataFetchHandlerInterface
         */
        private $handler;

        /**
         * @var array
         */
        private $result;

        /**
         * @param AbstractResponse          $response
         * @param DataFetchHandlerInterface $handler
         */
        public function __construct(
            AbstractResponse $response,
            DataFetchHandlerInterface $handler
        )
        {
            parent::__construct($response);
            $this->handler = $handler;
        }

        protected function run()
        {
            $this->result = $this->handler->execute($this->getRequest());
        }

        /**
         * @return string
         */
        protected function getRendererResultBody()
        {
            return $this->result;
        }
    }
}
