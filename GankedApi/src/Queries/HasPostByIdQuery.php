<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\API\Services\PostsService;

    class HasPostByIdQuery
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
         * @param \MongoId $id
         *
         * @return bool
         */
        public function execute(\MongoId $id)
        {
            return $this->postsService->getPostById($id) !== null;
        }
   
    }
}
