<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Models
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\Skeleton\Http\StatusCodes\NotFound;

    /**
     * @covers Ganked\API\Models\ApiModel
     * @uses Ganked\API\Exceptions\ApiException
     */
    class ApiModelTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var ApiModel
         */
        private $model;

        protected function setUp()
        {
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = new ApiModel($uri);
        }

        public function testSetAndGetDataWorks()
        {
            $data = ['foo' => 'bar'];

            $this->model->setData($data);
            $this->assertSame($data, $this->model->getData());
        }

        public function testSetAndGetExceptionWorks()
        {
            $exception = new ApiException('', 0, null, new NotFound);
            $this->model->setException($exception);
            $this->assertSame($exception, $this->model->getException());
        }

        public function testHasExceptionReturnsExpectedBool()
        {
            $this->assertFalse($this->model->hasException());

            $exception = new ApiException('', 0, null, new NotFound);
            $this->model->setException($exception);
            $this->assertTrue($this->model->hasException());
        }

        public function testSetAndGetObjectTypeWorks()
        {
            $type = 'test';
            $this->model->setObjectType($type);
            $this->assertSame($type, $this->model->getObjectType());
        }
    }
}
