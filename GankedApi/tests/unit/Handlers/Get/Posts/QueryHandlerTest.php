<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Get\Posts
{

    /**
     * @covers Ganked\API\Handlers\Get\Posts\QueryHandler
     * @uses \Ganked\API\Exceptions\ApiException
     */
    class QueryHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var QueryHandler
         */
        private $queryHandler;
        private $postByIdQuery;
        private $request;
        private $uri;
        private $model;

        protected function setUp()
        {
            $this->postByIdQuery = $this->getMockBuilder(\Ganked\API\Queries\GetPostByIdQuery::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model = $this->getMockBuilder(\Ganked\API\Models\ApiModel::class)
                ->disableOriginalConstructor()
                ->getMock();


            $this->queryHandler = new QueryHandler($this->postByIdQuery);
        }

        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testExceptionFromQueryTriggersLogicException()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/posts/123456789123456789123456'));

            $this->postByIdQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\MongoId::class))
                ->will($this->throwException(new \Exception));

            $this->queryHandler->execute($this->request, $this->model);
        }

        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testNonExistingUserTriggersException()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/users/123456789123456789123456'));

            $this->postByIdQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\MongoId::class))
                ->will($this->returnValue(null));

            $this->queryHandler->execute($this->request, $this->model);
        }

        public function testRetrievingExistingUserWithSpecificFieldsReturnsExpectedValues()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/users/123456789123456789123456'));

            $this->postByIdQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\MongoId::class))
                ->will($this->returnValue(['text' => 'foobar']));

            $this->model
                ->expects($this->once())
                ->method('setData')
                ->with(['text' => 'foobar']);

            $this->queryHandler->execute($this->request, $this->model);
        }

    }
}
