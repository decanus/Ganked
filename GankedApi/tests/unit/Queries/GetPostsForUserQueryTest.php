<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{

    use Ganked\Library\ValueObjects\UserId;

    /**
     * @covers Ganked\API\Queries\GetPostsForUserQuery
     */
    class GetPostsForUserQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $postsService = $this->getMockBuilder(\Ganked\API\Services\PostsService::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new GetPostsForUserQuery($postsService);
            $username = new UserId('55dac07209edfe700d8b4567');

            $postsService->expects($this->once())->method('getPostsForUser')->with($username, 0, 0)->will($this->returnValue(['foo']));
            $this->assertSame(['foo'], $query->execute($username));
        }
    }
}
