<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{

    /**
     * @covers Ganked\API\Queries\FetchPostsByIdsQuery
     */
    class FetchPostsByIdsQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $postsService = $this->getMockBuilder(\Ganked\API\Services\PostsService::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new FetchPostsByIdsQuery($postsService);

            $postsService->expects($this->once())->method('getPostsByIds')->with([])->will($this->returnValue(['foo']));
            $this->assertSame(['foo'], $query->execute([]));
        }
    }
}
