<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Get\Users\Posts
{
    /**
     * @covers Ganked\API\Handlers\Get\Users\Posts\QueryHandler
     */
    class QueryHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var QueryHandler
         */
        private $queryHandler;
        private $getPostsForUserQuery;
        private $request;
        private $uri;
        private $model;

        protected function setUp()
        {
            $this->getPostsForUserQuery = $this->getMockBuilder(\Ganked\API\Queries\GetPostsForUserQuery::class)
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

            $this->queryHandler = new QueryHandler($this->getPostsForUserQuery);
        }

        public function testNoPostsReturnsEmptyArray()
        {
            $this->request
                ->expects($this->at(0))
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/users/566e890509edfe77108b4567/posts'));

            $this->request
                ->expects($this->at(1))
                ->method('hasParameter')
                ->with('skip')
                ->will($this->returnValue(false));

            $this->request
                ->expects($this->at(2))
                ->method('hasParameter')
                ->with('limit')
                ->will($this->returnValue(false));

            $this->getPostsForUserQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\UserId::class), 0, 0)
                ->will($this->returnValue(null));

            $this->model
                ->expects($this->once())
                ->method('setData')
                ->with([]);

            $this->queryHandler->execute($this->request, $this->model);
        }

        public function testExecuteWorks()
        {
            $this->request
                ->expects($this->at(0))
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/users/566e890509edfe77108b4567/posts'));

            $this->request
                ->expects($this->at(1))
                ->method('hasParameter')
                ->with('skip')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('skip')
                ->will($this->returnValue('5'));

            $this->request
                ->expects($this->at(3))
                ->method('hasParameter')
                ->with('limit')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->at(4))
                ->method('getParameter')
                ->with('limit')
                ->will($this->returnValue('5'));

            $id = new \MongoId;
            $this->getPostsForUserQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\UserId::class), 5, 5)
                ->will($this->returnValue([['_id' => $id], ['_id' => $id]]));

            $this->model
                ->expects($this->once())
                ->method('setData')
                ->with([['id' => $id], ['id' => $id]]);

            $this->queryHandler->execute($this->request, $this->model);
        }

    }
}
