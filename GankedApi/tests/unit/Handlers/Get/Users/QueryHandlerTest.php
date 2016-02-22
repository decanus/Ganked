<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Get\Users
{

    /**
     * @covers Ganked\API\Handlers\Get\Users\QueryHandler
     * @uses \Ganked\API\Exceptions\ApiException
     */
    class QueryHandlerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var QueryHandler
         */
        private $queryHandler;
        private $getUserFromDatabaseQuery;
        private $request;
        private $uri;
        private $model;
        private $fetchUserByIdQuery;
        private $fetchUserBySteamIdQuery;

        protected function setUp()
        {
            $this->getUserFromDatabaseQuery = $this->getMockBuilder(\Ganked\API\Queries\GetUserFromDatabaseQuery::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->fetchUserByIdQuery = $this->getMockBuilder(\Ganked\API\Queries\FetchUserByIdQuery::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->fetchUserBySteamIdQuery = $this->getMockBuilder(\Ganked\API\Queries\FetchUserBySteamIdQuery::class)
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

            $this->queryHandler = new QueryHandler(
                $this->getUserFromDatabaseQuery,
                $this->fetchUserByIdQuery,
                $this->fetchUserBySteamIdQuery
            );
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
                ->method('getExplodedPath')
                ->will($this->returnValue(['users', 'foobar']));

            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('fields')
                ->will($this->returnValue(false));

            $this->getUserFromDatabaseQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Username::class), [])
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
                ->method('getExplodedPath')
                ->will($this->returnValue(['users', 'foobar']));

            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('fields')
                ->will($this->returnValue(false));

            $this->getUserFromDatabaseQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Username::class), [])
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
                ->method('getExplodedPath')
                ->will($this->returnValue(['users', 'foobar']));

            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('fields')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->with('fields')
                ->will($this->returnValue('username,firstname'));

            $this->getUserFromDatabaseQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Username::class), ['username', 'firstname'])
                ->will($this->returnValue(['username' => 'foobar', 'firstname' => 'seniorGanked']));

            $this->model
                ->expects($this->once())
                ->method('setData')
                ->with(['username' => 'foobar', 'firstname' => 'seniorGanked']);

            $this->queryHandler->execute($this->request, $this->model);
        }

        public function testRetrievingUserByIdReturnsExpectedValues()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getExplodedPath')
                ->will($this->returnValue(['users', '55dac07209edfe700d8b4567']));

            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('fields')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->with('fields')
                ->will($this->returnValue('username,firstname'));

            $this->fetchUserByIdQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\MongoId::class), ['username', 'firstname'])
                ->will($this->returnValue(['username' => 'foobar', 'firstname' => 'seniorGanked']));

            $this->model
                ->expects($this->once())
                ->method('setData')
                ->with(['username' => 'foobar', 'firstname' => 'seniorGanked']);

            $this->queryHandler->execute($this->request, $this->model);
        }

        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testNoUserThrowsException()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getExplodedPath')
                ->will($this->returnValue(['users', '55dac07209edfe700d8b4567']));

            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('fields')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->with('fields')
                ->will($this->returnValue('username,firstname'));

            $this->fetchUserByIdQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\MongoId::class), ['username', 'firstname'])
                ->will($this->returnValue(null));

            $this->queryHandler->execute($this->request, $this->model);
        }

        /**
         * @expectedException \Ganked\API\Exceptions\ApiException
         */
        public function testQueryErrorThrowsException()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getExplodedPath')
                ->will($this->returnValue(['users', '55dac07209edfe700d8b4567']));

            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('fields')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->with('fields')
                ->will($this->returnValue('username,firstname'));

            $this->fetchUserByIdQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\MongoId::class), ['username', 'firstname'])
                ->will($this->throwException(new \Exception('boom')));

            $this->queryHandler->execute($this->request, $this->model);
        }

        public function testRetrivingUserBySteamIdReturnsExpectedValue()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getExplodedPath')
                ->will($this->returnValue(['users', '550720970084567']));

            $this->request
                ->expects($this->once())
                ->method('hasParameter')
                ->with('fields')
                ->will($this->returnValue(true));

            $this->request
                ->expects($this->once())
                ->method('getParameter')
                ->with('fields')
                ->will($this->returnValue('username,firstname'));

            $this->fetchUserBySteamIdQuery
                ->expects($this->once())
                ->method('execute')
                ->will($this->returnValue(['username' => 'foobar', 'firstname' => 'seniorGanked']));

            $this->model
                ->expects($this->once())
                ->method('setData')
                ->with(['username' => 'foobar', 'firstname' => 'seniorGanked']);

            $this->queryHandler->execute($this->request, $this->model);
        }

    }
}
