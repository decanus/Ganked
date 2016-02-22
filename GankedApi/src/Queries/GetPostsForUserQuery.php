<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\API\Services\PostsService;
    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;

    class GetPostsForUserQuery
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
         * @param UserId $userId
         * @param int    $skip
         * @param int    $limit
         *
         * @return \MongoCursor
         */
        public function execute(UserId $userId, $skip = 0, $limit = 0)
        {
            return $this->postsService->getPostsForUser($userId, $skip, $limit);
        }
    }
}
