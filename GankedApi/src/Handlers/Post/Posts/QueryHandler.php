<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Post\Posts
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\QueryHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Models\ApiPostModel;
    use Ganked\API\Queries\FetchUserIdForAccessTokenQuery;
    use Ganked\Library\ValueObjects\Token;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var FetchUserIdForAccessTokenQuery
         */
        private $fetchUserIdForAccessTokenQuery;

        /**
         * @param FetchUserIdForAccessTokenQuery $fetchUserIdForAccessTokenQuery
         */
        public function __construct(FetchUserIdForAccessTokenQuery $fetchUserIdForAccessTokenQuery)
        {
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
        }
    }
}
