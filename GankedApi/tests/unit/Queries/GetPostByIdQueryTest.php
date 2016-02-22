<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{

    /**
     * @covers Ganked\API\Queries\GetPostByIdQuery
     */
    class GetPostByIdQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $postsService = $this->getMockBuilder(\Ganked\API\Services\PostsService::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new GetPostByIdQuery($postsService);

            $id = new \MongoId;
            $postsService->expects($this->once())->method('getPostById')->with($id)->will($this->returnValue(['foo']));
            $this->assertSame(['foo'], $query->execute($id));
        }
    }
}
