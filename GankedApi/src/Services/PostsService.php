<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Services
{

    use Ganked\Library\ValueObjects\UserId;

    class PostsService extends AbstractDatabaseService
    {
        /**
         * @param UserId $userId
         * @param int    $skip
         * @param int    $limit
         *
         * @return \MongoCursor
         */
        public function getPostsForUser(UserId $userId, $skip = 0, $limit = 0)
        {
            $result = $this->getDatabaseBackend()->findAll('posts', ['user' => (string) $userId])->sort(['created' => -1]);

            if ($skip !== 0) {
                $result->skip($skip);
            }

            if ($limit !== 0) {
                $result->limit($limit);
            }

            return $result;
        }

        /**
         * @param \MongoId $id
         *
         * @return array|null
         */
        public function getPostById(\MongoId $id)
        {
            return $this->getDatabaseBackend()->findOneInCollection('posts', ['_id' => $id]);
        }

        /**
         * @param \MongoId[] $ids
         *
         * @return \MongoCursor
         */
        public function getPostsByIds(array $ids)
        {
            return $this->getDatabaseBackend()->findAll('posts', ['_id' => ['$in' => $ids]]);
        }

        /**
         * @param array $post
         *
         * @return array|bool
         */
        public function insertPost(array $post)
        {
            return $this->getDatabaseBackend()->insertArrayInCollection($post, 'posts');
        }

        /**
         * @param string $userId
         * @param string $postId
         */
        public function likePost($userId, $postId)
        {
            $this->getDatabaseBackend()->insertArrayInCollection(['user' => $userId, 'post' => $postId], 'likes');
        }
    }
}
