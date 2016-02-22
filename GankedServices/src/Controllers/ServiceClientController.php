<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services\Controllers
{

    use Ganked\Services\Models\ServiceModel;
    use Ganked\Services\ServiceClients\AbstractServiceClient;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Response\AbstractResponse;

    class ServiceClientController extends AbstractPageController
    {

        /**
         * @var ServiceModel
         */
        private $model;

        /**
         * @var AbstractServiceClient
         */
        private $serviceClient;

        /**
         * @var string
         */
        private $body;

        /**
         * @param AbstractResponse         $response
         * @param ServiceModel             $model
         * @param AbstractServiceClient $serviceClient
         */
        public function __construct(
            AbstractResponse $response,
            ServiceModel $model,
            AbstractServiceClient $serviceClient
        )
        {
            parent::__construct($response);
            $this->model = $model;
            $this->serviceClient = $serviceClient;
        }

        protected function run()
        {
            $this->body = call_user_func_array(
                [$this->serviceClient, $this->model->getMethod()],
                $this->model->getArguments()
            );
        }

        protected function getRendererResultBody()
        {
            return $this->body;
        }
    }
}