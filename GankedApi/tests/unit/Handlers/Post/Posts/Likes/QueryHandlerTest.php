<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Post\Posts\Likes
{

    /**
     * @covers Ganked\API\Handlers\Post\Posts\Likes\QueryHandler
     * @uses \Ganked\API\Exceptions\ApiException
     */
    class QueryHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var QueryHandler
         */
        private $queryHandler;
        private $hasPostByIdQuery;
        private $fetchUserIdForAccessTokenQuery;
        private $request;
        private $model;
        private $uri;

        protected function setUp()
        {
            $this->hasPostByIdQuery = $this->getMockBuilder(\Ganked\API\Queries\HasPostByIdQuery::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->fetchUserIdForAccessTokenQuery = $this->getMockBuilder(\Ganked\API\Queries\FetchUserIdForAccessTokenQuery::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model = $this->getMockBuilder(\Ganked\API\Models\ApiPostModel::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->queryHandler = new QueryHandler($this->hasPostByIdQuery, $this->fetchUserIdForAccessTokenQuery);
        }

        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testInvalidMongoIdThrowsException()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/posts/foobar/likes'));

            $this->queryHandler->execute($this->request, $this->model);
        }

        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testExceptionIsThrownWhenPostDoesNotExist()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/posts/123412341234123412341234/likes'));

            $this->hasPostByIdQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\MongoId::class))
                ->will($this->returnValue(false));

            $this->queryHandler->execute($this->request, $this->model);
        }
        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testExceptionIsThrownWhenAccessTokenParameterIsMissing()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/posts/123412341234123412341234/likes'));

            $this->hasPostByIdQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\MongoId::class))
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('access_token')
                ->will($this->returnValue(false));

            $this->queryHandler->execute($this->request, $this->model);
        }

        public function testExecuteWorks()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/posts/123412341234123412341234/likes'));

            $this->hasPostByIdQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\MongoId::class))
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('access_token')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->with('access_token')
                ->will($this->returnValue('1234'));

            $this->fetchUserIdForAccessTokenQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Token::class))
                ->will($this->returnValue('123'));

            $this->model
                ->expects($this->once())
                ->method('setUserId')
                ->with('123');

            $this->queryHandler->execute($this->request, $this->model);
        }
    }
}
