<?php

/**
 * This file contains the ApiBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter\Tests;

use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains the tests for the Api.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Spark\Twitter\Api
 */
class ApiBaseTest extends ApiTest
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
     * Test that the Curl class is passed correctly.
     */
    public function testCurlIsSetCorrectly()
    {
        $this->assertPropertySame('curl', $this->curl);
    }

    /**
     * Test that __get() gets existing credential values from the CAS.
     *
     * @param String $key Credential key
     *
     * @dataProvider generalKeyProvider
     * @covers       Lunr\Spark\Twitter\Api::__get
     */
    public function testGetExistingCredentials($key)
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo($key))
                  ->will($this->returnValue('value'));

        $this->assertEquals('value', $this->class->{$key});
    }

    /**
     * Test that __get() returns NULL for non-existing credential keys.
     *
     * @covers Lunr\Spark\Twitter\Api::__get
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
     * @param String $key Credential key
     *
     * @dataProvider generalKeyProvider
     * @covers       Lunr\Spark\Twitter\Api::__set
     */
    public function testSetGeneralCredentials($key)
    {
        $this->cas->expects($this->once())
                  ->method('add')
                  ->with($this->equalTo('twitter'), $this->equalTo($key), $this->equalTo('value'));

        $this->class->{$key} = 'value';
    }

    /**
     * Test that setting an invalid key does not touch the CAS.
     *
     * @covers Lunr\Spark\Twitter\Api::__set
     */
    public function testSetInvalidKeyDoesNotAlterCAS()
    {
        $this->cas->expects($this->never())
                  ->method('add');

        $this->class->invalid = 'value';
    }

}

?>
