<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Models
{

    /**
     * @covers Ganked\API\Models\ApiPostModel
     */
    class ApiPostModelTest extends \PHPUnit_Framework_TestCase
    {
        public function testSetAndGetUserIdWorks()
        {
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $model = new ApiPostModel($uri);

            $userId = '1234';
            $model->setUserId($userId);
            $this->assertSame($userId, $model->getUserId());
        }
    }
}
