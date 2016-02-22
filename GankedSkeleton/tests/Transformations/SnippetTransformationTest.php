<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Transformations
{

    use Ganked\Library\Helpers\DomHelper;

    /**
     * @covers Ganked\Skeleton\Transformations\SnippetTransformation
     * @covers Ganked\Skeleton\Transformations\AbstractTransformation
     * @uses Ganked\Library\Helpers\DomHelper
     */
    class SnippetTransformationTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var SnippetTransformation
         */
        private $transformation;

        /**
         * @var DomHelper
         */
        private $template;

        protected function setUp()
        {
            $this->template = new DomHelper('<div id="div"><main id="main"/> <notSoMain id="bleh" /></div>');
            $this->transformation = new SnippetTransformation;
            $this->transformation->setTemplate($this->template);
        }

        public function testRemoveElementWithIdWorks()
        {
            $this->transformation->removeElementWithId('main');
            $this->assertFalse($this->template->hasElementById('main'));
        }

        /**
         * @expectedException \OutOfBoundsException
         */
        public function testNotFoundIdThrowsException()
        {
            $this->transformation->removeElementWithId('123231');
        }

        public function testAppendToIdWorks()
        {
            $dom = new DomHelper('<p/>');
            $this->transformation->appendToId('main', $dom);

            $this->assertXmlStringEqualsXmlString(
                '<div id="div"><main id="main"><p/></main> <notSoMain id="bleh" /></div>',
                $this->template->saveXML()
            );

        }

        public function testReplaceElementWithIdWorks()
        {
            $dom = new DomHelper('<p/>');
            $this->transformation->replaceElementWithId('main', $dom);

            $this->assertXmlStringEqualsXmlString(
                '<div id="div"><p/> <notSoMain id="bleh" /></div>',
                $this->template->saveXML()
            );
        }

        public function testAppendToMainWorks()
        {
            $dom = new DomHelper('<p/>');
            $this->transformation->appendToMain($dom);

            $this->assertXmlStringEqualsXmlString(
                '<div id="div"><main id="main"><p/></main> <notSoMain id="bleh" /></div>',
                $this->template->saveXML()
            );
        }

        public function testPrependToElementWithIdWorks()
        {
            $dom = new DomHelper('<p/>');
            $this->transformation->prependToElementWithId('div', $dom);

            $this->assertXmlStringEqualsXmlString(
                '<div id="div"><p/><main id="main" /> <notSoMain id="bleh" /></div>',
                $this->template->saveXML()
            );
        }

        public function testInsertBeforeElementWithIdWorks()
        {
            $dom = new DomHelper('<p/>');
            $this->transformation->insertBeforeElementWithId('bleh', $dom);

            $this->assertXmlStringEqualsXmlString(
                '<div id="div"><main id="main" /> <p/><notSoMain id="bleh" /></div>',
                $this->template->saveXML()
            );
        }

    }
}
