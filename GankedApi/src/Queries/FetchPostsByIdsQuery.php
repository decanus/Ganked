<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\API\Services\PostsService;

    class FetchPostsByIdsQuery
    {
        /**
         * @var PostsService
         */
        private $postsService;

        /**
         * @param PostsService $postsService
         */
        public function __construct(PostsService $postsService)
        {
            $this->postsService = $postsService;
        }

        /**
         * @param \MongoId[] $ids
         *
         * @return \MongoCursor
         */
        public function execute(array $ids)
        {
            return $this->postsService->getPostsByIds($ids);
        }
   
    }
}
