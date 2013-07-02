<?php

/**
 * This file contains the InterRequestTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Core\Configuration;
use Lunr\Corona\InterRequest;
use Lunr\Corona\Request;
use ReflectionClass;
use Lunr\Halo\LunrBaseTest;

/**
 * This class contains the tests for the class class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Corona\InterRequest
 */
class InterRequestTest extends LunrBaseTest
{

    /**
     * The Mock instance of the request class.
     * @var Request
     */
    private $request;

    /**
     * The overridden values of the Request class.
     * @var array
     */
    private $overridden;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                        ->disableOriginalConstructor()
                        ->getMock();

        $this->overridden = array(
            'controller' => 'controller',
            'method'     => 'method',
            'params'     => 'params'
        );

        $this->class      = new InterRequest($this->request, $this->overridden);
        $this->reflection = new ReflectionClass('Lunr\Corona\InterRequest');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Unit Test Data Provider for Constructor values.
     *
     * @return array $values Set of request values
     */
    public function valuesProvider()
    {
        $values   = array();
        $values[] = array('controller');
        $values[] = array('method');
        $values[] = array('params');

        return $values;
    }

    /**
     * Unit Test Data Provider for request method calls.
     *
     * @return array $values Set of request values
     */
    public function methodCallProvider()
    {
        $values   = array();
        $values[] = array('get_get_data');
        $values[] = array('get_post_data');
        $values[] = array('get_cookie_data');

        return $values;
    }

    /**
     * Unit Test Data Provider for request values.
     *
     * @return array $values Set of request values
     */
    public function requestKeyProvider()
    {
        $values   = array();
        $values[] = array('sapi');
        $values[] = array('host');
        $values[] = array('base_path');
        $values[] = array('protocol');
        $values[] = array('domain');
        $values[] = array('port');
        $values[] = array('host');
        $values[] = array('base_url');

        return $values;
    }

    /**
     * Test that request property inits with given parameter in constructor.
     *
     * @covers Lunr\Corona\InterRequest::__construct
     */
    public function testRequestIsPassedCorrectly()
    {
        $value = $this->get_reflection_property_value('request');

        $this->assertSame($value, $this->request);
    }

    /**
     * Test that request property inits with given parameter in constructor.
     *
     * @covers Lunr\Corona\InterRequest::__construct
     */
    public function testOverriddenIsPassedCorrectly()
    {
        $value = $this->get_reflection_property_value('overridden');

        $this->assertEquals($value, $this->overridden);
    }

    /**
     * Tests that magic getters returns parameters given by constructor.
     *
     * @param String $key The key to test
     *
     * @dataProvider valuesProvider
     * @covers       Lunr\Corona\InterRequest::__get
     */
    public function testMagicGetReturnsOverriddenValues($key)
    {
        $this->assertEquals($this->overridden[$key], $this->class->$key);
    }

    /**
     * Test that magic getter forwards requests for non overriden values to the request class.
     *
     * @param String $key The key to test
     *
     * @dataProvider requestKeyProvider
     * @covers Lunr\Corona\InterRequest::__get
     */
    public function testMagicGetForwardsNonOverriddenValues($key)
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->will($this->returnValue(NULL));

        $this->assertNull($this->class->$key);
    }

    /**
     * Tests that __call returns the same as the wrapped request object method.
     *
     * @param String $method The method to call
     *
     * @dataProvider methodCallProvider
     * @covers       Lunr\Corona\InterRequest::__call
     */
    public function testMagicCallForwardsCalls($method)
    {
        $this->request->expects($this->once())
                      ->method($method)
                      ->will($this->returnValue(NULL));

        $this->assertNull($this->class->$method('key'));
    }

}

?>
