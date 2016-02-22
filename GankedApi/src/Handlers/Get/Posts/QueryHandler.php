<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Get\Posts
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\QueryHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Queries\GetPostByIdQuery;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;
    use Ganked\Skeleton\Http\StatusCodes\InternalServerError;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var GetPostByIdQuery
         */
        private $postByIdQuery;

        /**
         * @param GetPostByIdQuery $postByIdQuery
         */
        public function __construct(GetPostByIdQuery $postByIdQuery)
        {
            $this->postByIdQuery = $postByIdQuery;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            $path = explode('/', $request->getUri()->getPath());

            try {
                $post = $this->postByIdQuery->execute(new \MongoId($path[2]));
            } catch (\Exception $e) {
                throw new ApiException('Unknown Error', 0, $e, new InternalServerError);
            }

            if ($post === null) {
                throw new ApiException('Post ' . $path[2] . ' does not exist', 0, null, new BadRequest);
            }

            $model->setData($post);
        }
    }
}
