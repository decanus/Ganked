<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Tasks
{

    /**
     * @covers Ganked\Backend\Tasks\InitialTask
     * @covers Ganked\Backend\Tasks\TaskInterface
     * @uses \Ganked\Backend\Request
     */
    class InitialTaskTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var InitialTask
         */
        private $initialTask;
        private $taskLocator;
        private $redisBackend;

        protected function setUp()
        {
            $this->redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->taskLocator = $this->getMockBuilder(\Ganked\Backend\Locators\TaskLocator::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->initialTask = new InitialTask(
                $this->taskLocator,
                $this->redisBackend
            );
        }

        public function testExecuteWorks()
        {
            $request = $this->getMockBuilder(\Ganked\Backend\Request::class)
                ->disableOriginalConstructor()
                ->getMock();
            $task = $this->getMockBuilder(\Ganked\Backend\Tasks\TaskInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->taskLocator
                ->expects($this->exactly(4))
                ->method('locate')
                ->with($this->isInstanceOf(\Ganked\Backend\Request::class))
                ->will($this->returnValue($task));

            $task->expects($this->exactly(4))->method('run')->with($this->isInstanceOf(\Ganked\Backend\Request::class));

            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('currentDataVersion')
                ->will($this->returnValue('1234'));

            $this->redisBackend
                ->expects($this->once())
                ->method('set');

            $this->redisBackend
                ->expects($this->once())
                ->method('delete')
                ->with('1234');

            $this->initialTask->run($request);
        }

    }
}
