<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Patch\Users
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\QueryHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Queries\FetchUserByIdQuery;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;
    use Ganked\Skeleton\Http\StatusCodes\Conflict;
    use Ganked\Skeleton\Http\StatusCodes\NotFound;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var FetchUserByIdQuery
         */
        private $fetchUserByIdQuery;

        /**
         * @param FetchUserByIdQuery $fetchUserByIdQuery
         */
        public function __construct(FetchUserByIdQuery $fetchUserByIdQuery)
        {
            $this->fetchUserByIdQuery = $fetchUserByIdQuery;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            $id = explode('/', ltrim($request->getUri()->getPath(), '/'))[1];

            $parameters = $request->getParameters();

            if (!isset($parameters['data']['attributes'])) {
                throw new ApiException('Nothing to update', 0, null, new BadRequest);
            }

            if (!isset($parameters['data']['id'])) {
                throw new ApiException('Id not set', 0, null, new Conflict);
            }

            if (!isset($parameters['data']['type']) || $parameters['data']['type'] !== 'users') {
                throw new ApiException('type conflict', 0, null, new Conflict);
            }

            if ($id !== $parameters['data']['id']) {
                throw new ApiException('Ids do not match', 0, null, new Conflict);
            }

            $id = new \MongoId($id);

            if ($this->fetchUserByIdQuery->execute($id) === null) {
                throw new ApiException('User not found', 0, null, new NotFound);
            }

        }
    }
}
