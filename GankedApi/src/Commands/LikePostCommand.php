<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Commands
{
    use Ganked\API\Services\PostsService;

    class LikePostCommand
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
         * @param string $userId
         * @param string $postId
         */
        public function execute($userId, $postId)
        {
            $this->postsService->likePost($userId, $postId);
        }
    }
}
