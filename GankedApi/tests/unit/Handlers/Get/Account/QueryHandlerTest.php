<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Get\Account
{
    /**
     * @covers Ganked\API\Handlers\Get\Account\QueryHandler
     * @uses \Ganked\API\Exceptions\ApiException
     */
    class QueryHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var QueryHandler
         */
        private $queryHandler;
        private $fetchAccountWithUsernameQuery;
        private $fetchAccountWithEmailQuery;
        private $request;
        private $uri;
        private $model;

        protected function setUp()
        {
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model = $this->getMockBuilder(\Ganked\API\Models\ApiModel::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->fetchAccountWithUsernameQuery = $this->getMockBuilder(\Ganked\API\Queries\FetchAccountWithUsernameQuery::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->fetchAccountWithEmailQuery = $this->getMockBuilder(\Ganked\API\Queries\FetchAccountWithEmailQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->queryHandler = new QueryHandler(
                $this->fetchAccountWithUsernameQuery,
                $this->fetchAccountWithEmailQuery
            );
        }

        public function testExecuteWorksWithEmail()
        {
            $email = 'test@ganked.net';
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));
            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/accounts/' . $email));

            $this->model
                ->expects($this->once())
                ->method('setObjectType')
                ->with('accounts');

            $this->fetchAccountWithEmailQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue([]));

            $this->model
                ->expects($this->once())
                ->method('setData');

            $this->queryHandler->execute($this->request, $this->model);
        }

        public function testExecuteWorksWithUsername()
        {
            $username = 'test';
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));
            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/accounts/' . $username));

            $this->model
                ->expects($this->once())
                ->method('setObjectType')
                ->with('accounts');

            $this->fetchAccountWithUsernameQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Username::class))
                ->will($this->returnValue([]));

            $this->model
                ->expects($this->once())
                ->method('setData');

            $this->queryHandler->execute($this->request, $this->model);
        }

        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testExecuteThrowsExceptionWhenAccountNotSet()
        {
            $username = 'test';
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));
            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/accounts/' . $username));

            $this->model
                ->expects($this->once())
                ->method('setObjectType')
                ->with('accounts');

            $this->fetchAccountWithUsernameQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Username::class))
                ->will($this->returnValue(null));

            $this->queryHandler->execute($this->request, $this->model);
        }
    }
}
