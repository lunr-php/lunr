<?php

/**
 * This file contains the BadRequestExceptionInputDataTest class.
 *
 * PHP Version 7.0
 *
 * @package Lunr\Corona\Exceptions
 * @author  Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Corona\Exceptions\Tests;

use Lunr\Corona\Exceptions\Tests\Helpers\HttpExceptionTest;
use Exception;

/**
 * This class contains tests for the BadRequestException class.
 *
 * @covers Lunr\Corona\Exceptions\BadRequestException
 */
class BadRequestExceptionInputDataTest extends HttpExceptionTest
{

    /**
     * Test that set_data() sets the data correctly.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::setData
     */
    public function testSetDataSetsData()
    {
        $this->class->setData('foo', 'bar');

        $this->assertPropertyEquals('key', 'foo');
        $this->assertPropertyEquals('value', 'bar');
        $this->assertTrue($this->get_reflection_property_value('dataAvailable'));
    }

    /**
     * Test that getDataKey() returns the data key.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::getDataKey
     */
    public function testGetDataKey()
    {
        $this->set_reflection_property_value('key', 'foo');

        $this->assertEquals('foo', $this->class->getDataKey());
    }

    /**
     * Test that getDataValue() returns the data value.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::getDataValue
     */
    public function testGetDataValue()
    {
        $this->set_reflection_property_value('value', 'bar');

        $this->assertEquals('bar', $this->class->getDataValue());
    }

    /**
     * Test that isDataAvailable() returns whether input data was set.
     *
     * @covers Lunr\Corona\Exceptions\BadRequestException::isDataAvailable
     */
    public function testIsDataAvailable()
    {
        $this->assertFalse($this->class->isDataAvailable());

        $this->set_reflection_property_value('dataAvailable', TRUE);

        $this->assertTrue($this->class->isDataAvailable());
    }

}

?>
