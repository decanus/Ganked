<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services\Controllers
{

    use Ganked\Services\Backends\SlackBackend;
    use Ganked\Services\Models\ServiceModel;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Response\AbstractResponse;

    class SlackController extends AbstractPageController
    {
        /**
         * @var ServiceModel
         */
        private $model;

        /**
         * @var SlackBackend
         */
        private $backend;

        /**
         * @param AbstractResponse        $response
         * @param ServiceModel            $model
         * @param SlackBackend            $backend
         */
        public function __construct(
            AbstractResponse $response,
            ServiceModel $model,
            SlackBackend $backend
        )
        {
            parent::__construct($response);
            $this->model = $model;
            $this->backend = $backend;
        }

        protected function run()
        {
            call_user_func_array([$this->backend, $this->model->getMethod()], $this->model->getArguments());
        }

        protected function getRendererResultBody()
        {
        }
    }
}