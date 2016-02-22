<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Controllers
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\AbstractResponseHandler;
    use Ganked\API\Handlers\CommandHandlerInterface;
    use Ganked\API\Handlers\PreHandler;
    use Ganked\API\Handlers\QueryHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Response\AbstractResponse;

    abstract class AbstractApiController extends AbstractPageController
    {
        /**
         * @var ApiModel
         */
        private $model;

        /**
         * @var PreHandler
         */
        private $preHandler;

        /**
         * @var QueryHandlerInterface
         */
        private $queryHandler;

        /**
         * @var AbstractResponseHandler
         */
        private $responseHandler;

        /**
         * @var array
         */
        private $body;
        /**
         * @var CommandHandlerInterface
         */
        private $commandHandler;

        /**
         * @param AbstractResponse        $response
         * @param ApiModel                $model
         * @param PreHandler              $preHandler
         * @param QueryHandlerInterface   $queryHandler
         * @param CommandHandlerInterface $commandHandler
         * @param AbstractResponseHandler $responseHandler
         */
        public function __construct(
            AbstractResponse $response,
            ApiModel $model,
            PreHandler $preHandler,
            QueryHandlerInterface $queryHandler,
            CommandHandlerInterface $commandHandler,
            AbstractResponseHandler $responseHandler
        )
        {
            parent::__construct($response);
            $this->model = $model;
            $this->preHandler = $preHandler;
            $this->queryHandler = $queryHandler;
            $this->responseHandler = $responseHandler;
            $this->commandHandler = $commandHandler;
        }

        protected function run()
        {
            $request = $this->getRequest();
            $model = $this->getModel();

            try {
                $this->preHandler->execute($request);
                $this->queryHandler->execute($request, $model);
                $this->commandHandler->execute($request, $model);
            } catch (ApiException $e) {
                $this->getResponse()->setStatusCode($e->getStatusCode());
                $model->setException($e);
            }

            $this->body = $this->responseHandler->execute($model);
        }


        /**
         * @return string
         */
        protected function getRendererResultBody()
        {
            return json_encode($this->body, true);
        }

        /**
         * @return ApiModel
         */
        protected function getModel()
        {
            return $this->model;
        }
    }
}
