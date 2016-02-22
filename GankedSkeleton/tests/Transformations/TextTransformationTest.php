<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Transformations
{

    use Ganked\Library\Helpers\DomHelper;

    /**
     * @covers Ganked\Skeleton\Transformations\TextTransformation
     * @covers Ganked\Skeleton\Transformations\AbstractTransformation
     * @uses Ganked\Library\Helpers\DomHelper
     */
    class TextTransformationTest extends \PHPUnit_Framework_TestCase
    {
        public function testAppendTextToIdWorks()
        {
            $dom = new DomHelper('<div><div id="foo"/><div id="bar"/></div>');

            $transformation = new TextTransformation;
            $transformation->setTemplate($dom);

            $transformation->appendTextToId('bar', 'test');

            $this->assertXmlStringEqualsXmlString(
                '<div><div id="foo"/><div id="bar">test</div></div>',
                $dom->saveXML()
            );
        }
    }
}
