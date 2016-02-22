<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Tasks
{

    use Ganked\Library\ValueObjects\DataVersion;

    /**
     * @covers Ganked\Backend\Tasks\BuildChampionPagesTask
     */
    class BuildChampionPagesTaskTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var BuildChampionPagesTask
         */
        private $task;

        private $championsPageBuilder;
        private $championPageBuilder;
        private $dataPoolReader;
        private $staticPageWriter;

        protected function setUp()
        {
            $this->championsPageBuilder = $this->getMockBuilder(\Ganked\Backend\Builders\ChampionsPageBuilder::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->championPageBuilder = $this->getMockBuilder(\Ganked\Backend\Builders\ChampionPageBuilder::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->dataPoolReader = $this->getMockBuilder(\Ganked\Library\DataPool\DataPoolReader::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->staticPageWriter = $this->getMockBuilder(\Ganked\Backend\Writers\StaticPageWriter::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->task = new BuildChampionPagesTask(
                $this->championsPageBuilder,
                $this->championPageBuilder,
                $this->dataPoolReader,
                $this->staticPageWriter
            );
        }

        public function testRunWorks()
        {
            $request = $this->getMockBuilder(\Ganked\Backend\Request::class)
                ->disableOriginalConstructor()
                ->getMock();

            $staticPage = $this->getMockBuilder(\Ganked\Backend\StaticPages\StaticPage::class)
                ->disableOriginalConstructor()
                ->getMock();

            $dataVersion = new DataVersion('20150909-2332');

            $request->expects($this->once())
                ->method('getParameter')
                ->with('dataVersion')
                ->will($this->returnValue((string) $dataVersion));

            $this->championsPageBuilder
                ->expects($this->once())
                ->method('build')
                ->will($this->returnValue($staticPage));

            $this->dataPoolReader
                ->expects($this->once())
                ->method('getAllChampions')
                ->will($this->returnValue(['["foo"]']));

            $this->championPageBuilder
                ->expects($this->once())
                ->method('build')
                ->with(['foo'])
                ->will($this->returnValue($staticPage));

            $this->staticPageWriter
                ->expects($this->exactly(2))
                ->method('write')
                ->with($dataVersion, $staticPage);

            $this->task->run($request);
        }
    }
}
