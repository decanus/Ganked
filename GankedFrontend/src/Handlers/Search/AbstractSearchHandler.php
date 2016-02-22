<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Handlers
{

    use Ganked\Frontend\Models\SearchPageModel;
    use Ganked\Skeleton\Models\AbstractPageModel;

    abstract class AbstractSearchHandler implements  HandlerInterface
    {
        /**
         * @var SearchPageModel
         */
        private $model;

        /**
         * @param AbstractPageModel $model
         */
        public function run(AbstractPageModel $model)
        {
            $this->model = $model;
            $this->doRun();
        }

        /**
         * @return SearchPageModel
         */
        protected function getModel()
        {
            return $this->model;
        }

        abstract protected function doRun();
    }
}
