<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers
{

    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Models\AbstractModel;

    abstract class AbstractHandler implements HandlerInterface
    {
        /**
         * @var AbstractModel
         */
        private $model;

        /**
         * @var AbstractRequest
         */
        private $request;


        /**
         * @param AbstractModel   $model
         * @param AbstractRequest $request
         *
         * @return array
         */
        public function execute(AbstractModel $model, AbstractRequest $request)
        {
            $this->model = $model;
            $this->request = $request;
            return $this->doExecute();
        }

        /**
         * @return AbstractModel
         */
        protected function getModel()
        {
            return $this->model;
        }

        /**
         * @return AbstractRequest
         */
        protected function getRequest()
        {
            return $this->request;
        }

        /**
         * @return array
         */
        abstract protected function doExecute();
    }
}
