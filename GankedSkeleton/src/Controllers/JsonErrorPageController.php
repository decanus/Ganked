<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Controllers
{

    use Ganked\Skeleton\Http\Response\ResponseInterface;
    use Ganked\Skeleton\Http\StatusCodes\InternalServerError;
    use Ganked\Skeleton\Http\StatusCodes\NotFound;
    use Ganked\Skeleton\Models\JsonErrorPageModel;

    class JsonErrorPageController extends AbstractPageController
    {
        /**
         * @var JsonErrorPageModel
         */
        private $model;

        /**
         * @param ResponseInterface  $response
         * @param JsonErrorPageModel $model
         */
        public function __construct(
            ResponseInterface $response,
            JsonErrorPageModel $model
        )
        {
            parent::__construct($response);
            $this->model = $model;
        }

        protected function run()
        {
            if ($this->model->getResponseCode() === 404) {
                $this->getResponse()->setStatusCode(new NotFound);
            }

            if ($this->model->getResponseCode() === 500) {
                $this->getResponse()->setStatusCode(new InternalServerError);
            }

//            $this->setResponseCode($this->model->getResponseCode());
        }

        protected function getRendererResultBody()
        {
            return json_encode($this->model->getContent());
        }
    }
}
