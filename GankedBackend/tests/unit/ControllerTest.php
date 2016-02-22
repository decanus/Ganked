<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend
{
    /**
     * @covers Ganked\Backend\Controller
     */
    class ControllerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Controller
         */
        private $controller;

        private $bootstrapper;
        private $masterFactory;
        private $request;
        private $task;
        private $taskLocator;
        private $parameters;

        protected function setUp()
        {
            $this->bootstrapper = $this->getMockBuilder(\Ganked\Backend\Bootstrapper::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->masterFactory = $this->getMockBuilder(\Ganked\Skeleton\Factories\MasterFactory::class)
                ->disableOriginalConstructor()
                ->setMethods(['createTaskLocator'])
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Backend\Request::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->task = $this->getMockBuilder(\Ganked\Backend\Tasks\BuildStaticPageTask::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->taskLocator = $this->getMockBuilder(\Ganked\Backend\Locators\TaskLocator::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->parameters = $this->getMockBuilder(\Ganked\Skeleton\Map::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->controller = new Controller($this->bootstrapper);
        }

        public function testRunWorks()
        {
            $this->bootstrapper
                ->expects($this->once())
                ->method('getRequest')
                ->will($this->returnValue($this->request));

            $this->bootstrapper
                ->expects($this->once())
                ->method('getFactory')
                ->will($this->returnValue($this->masterFactory));

            $this->masterFactory
                ->expects($this->once())
                ->method('createTaskLocator')
                ->will($this->returnValue($this->taskLocator));

            $this->taskLocator
                ->expects($this->once())
                ->method('locate')
                ->with($this->request)
                ->will($this->returnValue($this->task));

            $this->controller->run();
        }
    }
}
