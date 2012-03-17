<?php

/**
 * This file contains the ResponseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the Response class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Response
 */
class ResponseTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the response object.
     * @var Response
     */
    private $response;

    /**
     * Reflection instance of the response object.
     * @var ReflectionClass
     */
    private $response_reflection;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->response = new Response();
        $this->response_reflection = new ReflectionClass('Lunr\Libraries\Core\Response');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->response);
        unset($this->response_reflection);
    }

    /**
     * Test that the data array is empty by default.
     */
    public function testDataEmptyByDefault()
    {
        $property = $this->response_reflection->getProperty('data');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->response);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that there is no error message set by default.
     */
    public function testErrorMessageEmptyByDefault()
    {
        $property = $this->response_reflection->getProperty('errmsg');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->response));
    }

    /**
     * Test that there is no error information set by default.
     */
    public function testErrorInfoEmptyByDefault()
    {
        $property = $this->response_reflection->getProperty('errinfo');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->response));
    }

    /**
     * Test that the default return code is zero.
     */
    public function testReturnCodeIsZeroByDefault()
    {
        $property = $this->response_reflection->getProperty('return_code');
        $property->setAccessible(TRUE);

        $this->assertEquals(0, $property->getValue($this->response));
    }

    /**
     * Test adding response data,
     *
     * @depends testDataEmptyByDefault
     * @covers  Lunr\Libraries\Core\Response::add_response_data
     */
    public function testAddResponseData()
    {
        $property = $this->response_reflection->getProperty('data');
        $property->setAccessible(TRUE);

        $this->response->add_response_data('key', 'value');

        $value = $property->getValue($this->response);

        $this->assertArrayHasKey('key', $value);
        $this->assertEquals('value', $value['key']);
    }

    /**
     * Test getting existing response data.
     *
     * @depends testAddResponseData
     * @covers  Lunr\Libraries\Core\Response::get_response_data
     */
    public function testGetResponseDataWithExistingKey()
    {
        $this->response->add_response_data('key', 'value');

        $this->assertEquals('value', $this->response->get_response_data('key'));
    }

    /**
     * Test getting non-existing response data.
     *
     * @covers  Lunr\Libraries\Core\Response::get_response_data
     */
    public function testGetResponseDataWithNonExistingKey()
    {
        $this->assertNull($this->response->get_response_data('non-existing'));
    }

    /**
     * Test setting an error message.
     *
     * @covers Lunr\Libraries\Core\Response::__set
     */
    public function testSetErrorMessage()
    {
        $property = $this->response_reflection->getProperty('errmsg');
        $property->setAccessible(TRUE);

        $this->response->errmsg = 'Message';

        $this->assertEquals('Message', $property->getValue($this->response));
    }

    /**
     * Test setting an error information.
     *
     * @covers Lunr\Libraries\Core\Response::__set
     */
    public function testSetErrorInformation()
    {
        $property = $this->response_reflection->getProperty('errinfo');
        $property->setAccessible(TRUE);

        $this->response->errinfo = 'Info';

        $this->assertEquals('Info', $property->getValue($this->response));
    }

    /**
     * Test setting a valid return code.
     *
     * @covers Lunr\Libraries\Core\Response::__set
     */
    public function testSetValidReturnCode()
    {
        $property = $this->response_reflection->getProperty('return_code');
        $property->setAccessible(TRUE);

        $this->response->return_code = 503;

        $this->assertEquals(503, $property->getValue($this->response));
    }

    /**
     * Test setting a valid return code.
     *
     * @param mixed $code Invalid return code value.
     *
     * @dataProvider invalidReturnCodeProvider
     * @covers       Lunr\Libraries\Core\Response::__set
     */
    public function testSetInvalidReturnCode($code)
    {
        $property = $this->response_reflection->getProperty('return_code');
        $property->setAccessible(TRUE);

        $this->response->return_code = $code;

        $this->assertEquals(0, $property->getValue($this->response));
    }

    /**
     * Test that setting data directly does not work.
     *
     * @covers Lunr\Libraries\Core\Response::__set
     */
    public function testSetDataDirectlyDoesNotWork()
    {
        $property = $this->response_reflection->getProperty('data');
        $property->setAccessible(TRUE);

        $this->response->data = 'value';

        $value = $property->getValue($this->response);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test getting existing attributes via __get.
     *
     * @param String $attr  Attribute name
     * @param mixed  $value Expected attribute value
     *
     * @depends      testErrorInfoEmptyByDefault
     * @depends      testErrorMessageEmptyByDefault
     * @depends      testReturnCodeIsZeroByDefault
     * @dataProvider validResponseAttributesProvider
     * @covers       Lunr\Libraries\Core\Response::__get
     */
    public function testGettingExistingAttributes($attr, $value)
    {
        $this->assertEquals($value, $this->response->$attr);
    }

    /**
     * Test that getting data does not work.
     *
     * @covers Lunr\Libraries\Core\Response::__get
     */
    public function testGettingDataDoesNotWork()
    {
        $this->assertNull($this->response->data);
    }

    /**
     * Unit test data provider for invalid return codes.
     *
     * @return array $codes Array of invalid return codes.
     */
    public function invalidReturnCodeProvider()
    {
        $codes   = array();
        $codes[] = array('502');
        $codes[] = array(4.5);
        $codes[] = array(TRUE);
        $codes[] = array(array());

        return $codes;
    }

    /**
     * Unit test data provider for attributes accessible over __get.
     *
     * @return array $attrs Array of attribute names and their default values.
     */
    public function validResponseAttributesProvider()
    {
        $attrs   = array();
        $attrs[] = array('errmsg', '');
        $attrs[] = array('errinfo', '');
        $attrs[] = array('return_code', 0);

        return $attrs;
    }
}

?>
