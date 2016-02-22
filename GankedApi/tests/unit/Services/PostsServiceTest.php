<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Services
{

    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;

    /**
     * @covers Ganked\API\Services\PostsService
     * @covers \Ganked\API\Services\AbstractDatabaseService
     */
    class PostsServiceTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var PostsService
         */
        private $postsService;
        private $mongoDatabaseBackend;

        protected function setUp()
        {
            $this->mongoDatabaseBackend = $this->getMockBuilder(\Ganked\Library\Backends\MongoDatabaseBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->postsService = new PostsService($this->mongoDatabaseBackend);
        }

        public function testGetPostsForUserReturnsExpectedValue()
        {
            $username = new UserId('55dac07209edfe700d8b4567');

            $mongoCursor = $this->getMockBuilder(\MongoCursor::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('findAll')
                ->with('posts', ['user' => (string) $username])
                ->will($this->returnValue($mongoCursor));

            $mongoCursor->expects($this->once())->method('sort')->will($this->returnValue($mongoCursor));
            $mongoCursor->expects($this->once())->method('skip')->with(5);
            $mongoCursor->expects($this->once())->method('limit')->with(5);

            $this->assertSame($mongoCursor, $this->postsService->getPostsForUser($username, 5, 5));
        }

        public function testGetPostByIdReturnsExpectedValue()
        {
            $id = new \MongoId;

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('findOneInCollection')
                ->with('posts', ['_id' => $id])
                ->will($this->returnValue(['foo' => 'bar']));

            $this->assertSame(['foo' => 'bar'], $this->postsService->getPostById($id));
        }

        public function testGetPostsByIdsReturnsExpectedValue()
        {
            $ids = [new \MongoId, new \MongoId];

            $mongoCursor = $this->getMockBuilder(\MongoCursor::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('findAll')
                ->with('posts', ['_id' => ['$in' => $ids]])
                ->will($this->returnValue($mongoCursor));

            $this->assertSame($mongoCursor, $this->postsService->getPostsByIds($ids));
        }

        public function testLikePostWorks()
        {
            $userId = '1234';
            $postId = '1234';
            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('insertArrayInCollection')
                ->with(['user' => $userId, 'post' => $postId], 'likes');

            $this->postsService->likePost($userId, $postId);
        }
    }
}
