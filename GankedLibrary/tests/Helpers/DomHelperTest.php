<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Helpers
{
    /**
     * @covers Ganked\Library\Helpers\DomHelper
     */
    class DomHelperTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var DomHelper
         */
        private $helper;

        protected function setUp()
        {
            $this->helper = new DomHelper();
        }

        public function testGetFirstElementByTagNameWorks()
        {
            $this->helper->loadXML('<html><div>a</div><div>b</div></html>');
            $this->assertSame('a', $this->helper->getFirstElementByTagName('div')->nodeValue);
        }

        public function testLoadOnCreateWorks()
        {
            $dom = new DomHelper('<div>test</div>');
            $this->assertXmlStringEqualsXmlString('<?xml version="1.0"?><div>test</div>', $dom->saveXML());
        }

        public function testQueryWorks()
        {
            $this->helper->loadXML('<html><div>a</div><div>b</div></html>');
            $this->assertSame('a', $this->helper->query('//html/div')->item(0)->nodeValue);
        }

        public function testGetElementByIdWorks()
        {
            $this->helper->loadXML('<html><div>a</div><div id="b">b</div></html>');
            $this->assertSame('b', $this->helper->getElementById('b')->nodeValue);
        }

        public function testAppendElementWorks()
        {
            $this->helper->loadXML('<div></div>');
            $this->helper->appendElement('foo', 'bar');
            $this->assertSame('bar', $this->helper->getElementsByTagName('foo')->item(0)->nodeValue);
        }

        public function testHasElementByIdWorks()
        {
            $this->helper->loadXML('<div id="a"></div>');
            $this->assertTrue($this->helper->hasElementById('a'));
            $this->assertFalse($this->helper->hasElementById('b'));
        }

        public function testImportAndAppendChildWorks()
        {
            $this->helper->loadXML('<div><span></span><span id="target"></span></div>');
            $newNode = new DomHelper('<div>This is a test</div>');
            $target = $this->helper->query('//*[@id="target"]')->item(0);
            $this->helper->importAndAppendChild($target, $newNode->documentElement);
            $result = new DomHelper('<div><span></span><span id="target"><div>This is a test</div></span></div>');
            $this->assertEquals(
                $result->saveXML(),
                $this->helper->saveXML()
            );
        }

        public function testRemoveAllIdsWorks()
        {
            $this->helper->loadXML('<div id="a"><div id="as" data-render-keepid=""></div></div>');
            $this->helper->removeAllIds();
            $this->assertXmlStringEqualsXmlString(
                '<div><div id="as"></div></div>',
                $this->helper->saveXML()
            );
        }
    }
}
