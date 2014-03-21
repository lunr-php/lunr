<?php

/**
 * This file contains the RequestProxyBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains the tests for the class class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\RequestProxy
 */
class RequestProxyBaseTest extends RequestProxyTest
{

    /**
     * Test that request property inits with given parameter in constructor.
     *
     * @covers Lunr\Corona\RequestProxy::__construct
     */
    public function testRequestIsPassedCorrectly()
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that magic getter forwards requests for non overriden values to the request class.
     *
     * @param String $key The key to test
     *
     * @dataProvider requestKeyProvider
     * @covers       Lunr\Corona\RequestProxy::__get
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
     * @covers       Lunr\Corona\RequestProxy::__call
     */
    public function testMagicCallForwardsCalls($method)
    {
        $this->request->expects($this->once())
                      ->method($method)
                      ->will($this->returnValue(NULL));

        $this->assertNull($this->class->$method('key'));
    }

    /**
     * Test that redirect() replaces the request class that is proxied.
     *
     * @covers Lunr\Corona\RequestProxy::redirect
     */
    public function testRedirectReplacesRequestClass()
    {
        $new = $this->getMock('Lunr\Corona\RequestInterface');

        $this->class->redirect($new);

        $this->assertPropertySame('request', $new);
        $this->assertNotSame($new, $this->request);
    }

    /**
     * Test that redirect() ignores trying to replace the request class with a non-request class.
     *
     * @covers Lunr\Corona\RequestProxy::redirect
     */
    public function testRedirectIgnoresNonRequestClass()
    {
        $new = new \stdClass();

        $this->class->redirect($new);

        $this->assertPropertySame('request', $this->request);
    }

}

?>
