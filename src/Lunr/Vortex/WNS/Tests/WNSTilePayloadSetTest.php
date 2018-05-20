<?php

/**
 * This file contains the WNSTilePayloadSetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

/**
 * This class contains tests for the setters of the WNSTilePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSTilePayload
 */
class WNSTilePayloadSetTest extends WNSTilePayloadTest
{

    /**
     * Test set_text() works correctly with strings.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_text
     */
    public function testSetText()
    {
        $this->class->set_text('&text');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('text', $value);
        $this->assertEquals('&amp;text', $value['text'][0]);
    }

    /**
     * Test set_text() works correctly with line numbers.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_text
     */
    public function testSetTextLN()
    {
        $this->class->set_text('&text', 1);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('text', $value);
        $this->assertEquals('&amp;text', $value['text'][1]);
    }

    /**
     * Test set_text() works correctly with arrays.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_text
     */
    public function testSetTextArray()
    {
        $this->class->set_text([ 'Hello', 'Text', 'Test' ]);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('text', $value);
        $this->assertEquals([ 'Hello', 'Text', 'Test' ], $value['text']);
    }

    /**
     * Test fluid interface of set_text().
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_text
     */
    public function testSetTextReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_text('text'));
    }

    /**
     * Test set_image() works correctly with strings.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_image
     */
    public function testSetImage()
    {
        $this->class->set_image('&image');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('image', $value);
        $this->assertEquals('&amp;image', $value['image'][0]);
    }

    /**
     * Test set_image() works correctly with line numbers.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_image
     */
    public function testSetImageLN()
    {
        $this->class->set_image('&image', 1);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('image', $value);
        $this->assertEquals('&amp;image', $value['image'][1]);
    }

    /**
     * Test set_image() works correctly with arrays.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_image
     */
    public function testSetImageArray()
    {
        $this->class->set_image([ 'Hello', 'Image', 'Test' ]);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('image', $value);
        $this->assertEquals([ 'Hello', 'Image', 'Test' ], $value['image']);
    }

    /**
     * Test fluid interface of set_image().
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_image
     */
    public function testSetImageReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_image('image'));
    }

    /**
     * Test set_templates() works correctly.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_templates
     */
    public function testSetTemplates()
    {
        $this->class->set_templates([ 'HelloSQ', 'HelloW' ]);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('templates', $value);
        $this->assertEquals([ 'HelloSQ', 'HelloW' ], $value['templates']);
    }

    /**
     * Test fluid interface of set_templates().
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_templates
     */
    public function testSetTemplatesReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_templates('template', 'template'));
    }

}

?>
