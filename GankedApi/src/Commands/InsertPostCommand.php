<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Commands
{

    use Ganked\API\Services\PostsService;

    class InsertPostCommand
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
         * @param array $post
         *
         * @return array|bool
         */
        public function execute(array $post)
        {
            return $this->postsService->insertPost($post);
        }
    }
}
