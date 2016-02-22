<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Commands
{

    /**
     * @covers Ganked\API\Commands\LikePostCommand
     */
    class LikePostCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $postsService = $this->getMockBuilder(\Ganked\API\Services\PostsService::class)
                ->disableOriginalConstructor()
                ->getMock();

            $command = new LikePostCommand($postsService);

            $post = '12345';
            $user = '1234';

            $postsService->expects($this->once())->method('likePost')->with($user, $post);
            $command->execute($user, $post);
        }
    }
}
