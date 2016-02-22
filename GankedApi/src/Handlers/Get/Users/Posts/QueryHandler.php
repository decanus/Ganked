<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Get\Users\Posts
{
    use Ganked\API\Handlers\QueryHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Queries\GetPostsForUserQuery;
    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Skeleton\Http\Request\AbstractRequest;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var GetPostsForUserQuery
         */
        private $getPostsForUserQuery;

        /**
         * @param GetPostsForUserQuery $getPostsForUserQuery
         */
        public function __construct(GetPostsForUserQuery $getPostsForUserQuery)
        {
            $this->getPostsForUserQuery = $getPostsForUserQuery;
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

            $skip = 0;
            if ($request->hasParameter('skip')) {
                $skip = (int) $request->getParameter('skip');
            }

            $limit = 0;
            if ($request->hasParameter('limit')) {
                $limit = (int) $request->getParameter('limit');
            }

            $posts = $this->getPostsForUserQuery->execute(new UserId($path[2]), $skip, $limit);

            if ($posts === null) {
                $model->setData([]);
                return;
            }

            $data = [];
            foreach ($posts as $post) {
                $post['id'] =  (string) $post['_id'];
                unset($post['_id']);
                $data[] = $post;
            }

            $model->setData($data);
        }
    }
}
