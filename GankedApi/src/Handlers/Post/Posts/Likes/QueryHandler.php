<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Post\Posts\Likes
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\QueryHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Models\ApiPostModel;
    use Ganked\API\Queries\FetchUserIdForAccessTokenQuery;
    use Ganked\API\Queries\HasPostByIdQuery;
    use Ganked\API\Queries\HasUserByIdQuery;
    use Ganked\Library\ValueObjects\Token;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;
    use Ganked\Skeleton\Http\StatusCodes\Unauthorized;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var HasPostByIdQuery
         */
        private $hasPostByIdQuery;
        /**
         * @var FetchUserIdForAccessTokenQuery
         */
        private $fetchUserIdForAccessTokenQuery;

        /**
         * @param HasPostByIdQuery               $hasPostByIdQuery
         * @param FetchUserIdForAccessTokenQuery $fetchUserIdForAccessTokenQuery
         */
        public function __construct(
            HasPostByIdQuery $hasPostByIdQuery,
            FetchUserIdForAccessTokenQuery $fetchUserIdForAccessTokenQuery
        )
        {
            $this->hasPostByIdQuery = $hasPostByIdQuery;
            $this->fetchUserIdForAccessTokenQuery = $fetchUserIdForAccessTokenQuery;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            try {
                $postId = new \MongoId(explode('/', $request->getUri()->getPath())[2]);
            } catch (\Exception $e) {
                throw new ApiException('Invalid post ID', 0, $e, new BadRequest);
            }

            if (!$this->hasPostByIdQuery->execute($postId)) {
                throw new ApiException('Invalid post ID', 0, null, new BadRequest);
            }

            if (!$request->hasParameter('access_token')) {
                throw new ApiException('Invalid Access Token', 0, null, new Unauthorized);
            }

            /*** @var $model ApiPostModel */
            $model->setUserId(
                $this->fetchUserIdForAccessTokenQuery->execute(new Token($request->getParameter('access_token')))
            );

        }
    }
}
