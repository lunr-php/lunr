<?php

/**
 * This file contains the DeliveryApiBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Contentful
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains the tests for the DeliveryApi.
 *
 * @covers Lunr\Spark\Contentful\DeliveryApi
 */
class DeliveryApiBaseTest extends DeliveryApiTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the CentralAuthenticationStore class is passed correctly.
     */
    public function testCasIsSetCorrectly()
    {
        $this->assertPropertySame('cas', $this->cas);
    }

    /**
     * Test that the Requests_Session class is passed correctly.
     */
    public function testRequestsSessionIsSetCorrectly()
    {
        $this->assertPropertySame('http', $this->http);
    }

    /**
     * Test that __get() gets existing credential values from the CAS.
     *
     * @param string $key Credential key
     *
     * @dataProvider generalKeyProvider
     * @covers       Lunr\Spark\Contentful\DeliveryApi::__get
     */
    public function testGetExistingCredentials($key)
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo($key))
                  ->will($this->returnValue('value'));

        $this->assertEquals('value', $this->class->{$key});
    }

    /**
     * Test that __get() returns NULL for non-existing credential keys.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::__get
     */
    public function testGetNonExistingCredentials()
    {
        $this->cas->expects($this->never())
                  ->method('get');

        $this->assertNull($this->class->invalid);
    }

    /**
     * Test that __set() sets general credential values in the CAS.
     *
     * @param string $key Credential key
     *
     * @dataProvider generalKeyProvider
     * @covers       Lunr\Spark\Contentful\DeliveryApi::__set
     */
    public function testSetGeneralCredentials($key)
    {
        $this->cas->expects($this->once())
                  ->method('add')
                  ->with($this->equalTo('contentful'), $this->equalTo($key), $this->equalTo('value'));

        $this->class->{$key} = 'value';
    }

    /**
     * Test that setting an invalid key does not touch the CAS.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::__set
     */
    public function testSetInvalidKeyDoesNotAlterCAS()
    {
        $this->cas->expects($this->never())
                  ->method('add');

        $this->class->invalid = 'value';
    }

}

?>
