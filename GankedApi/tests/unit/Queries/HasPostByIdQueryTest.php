<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{

    /**
     * @covers Ganked\API\Queries\HasPostByIdQuery
     */
    class HasPostByIdQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $postsService = $this->getMockBuilder(\Ganked\API\Services\PostsService::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new HasPostByIdQuery($postsService);

            $id = new \MongoId;
            $postsService->expects($this->once())->method('getPostById')->with($id)->will($this->returnValue(['foo']));
            $this->assertTrue($query->execute($id));
        }
    }
}
