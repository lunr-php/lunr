<?php

/**
 * This file contains the RequestStoreTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Tests for storing superglobal values.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Corona\Request
 */
class RequestStoreTest extends RequestTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpEmpty();
    }

    /**
     * Test storing invalid $_COOKIE values.
     *
     * @param mixed $cookie Invalid $_COOKIE values
     *
     * @depends      Lunr\Corona\Tests\RequestBaseTest::testCookieEmpty
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\Request::store_cookie
     */
    public function testStoreInvalidCookieValuesLeavesLocalCookieEmpty($cookie)
    {
        $stored = $this->reflection_request->getProperty('cookie');
        $stored->setAccessible(TRUE);

        $method = $this->reflection_request->getMethod('store_cookie');
        $method->setAccessible(TRUE);

        $_COOKIE = $cookie;

        $method->invoke($this->request);

        $this->assertEmpty($stored->getValue($this->request));
    }

    /**
    * Test storing invalid $_COOKIE values.
    *
    * Checks whether the superglobal $_COOKIE is reset after passing
    * invalid cookie values in it.
    *
    * @param mixed $cookie Invalid $_COOKIE values
    *
    * @depends      Lunr\Corona\Tests\RequestBaseTest::testCookieEmpty
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_cookie
    */
    public function testStoreInvalidCookieValuesResetsSuperglobalCookie($cookie)
    {
        $method = $this->reflection_request->getMethod('store_cookie');
        $method->setAccessible(TRUE);

        $_COOKIE = $cookie;

        $method->invoke($this->request);

        $this->assertEmpty($_COOKIE);
    }

    /**
     * Test storing valid $_COOKIE values.
     *
     * @depends      Lunr\Corona\Tests\RequestBaseTest::testCookieEmpty
     * @covers       Lunr\Corona\Request::store_cookie
     */
    public function testStoreValidCookieValues()
    {
        $stored = $this->reflection_request->getProperty('cookie');
        $stored->setAccessible(TRUE);

        $method = $this->reflection_request->getMethod('store_cookie');
        $method->setAccessible(TRUE);

        $_COOKIE['test1'] = 'value1';
        $_COOKIE['test2'] = 'value2';
        $cache            = $_COOKIE;

        $method->invoke($this->request);

        $this->assertEquals($cache, $stored->getValue($this->request));
    }

    /**
     * Test that $_COOKIE is empty after storing.
     *
     * @depends Lunr\Corona\Tests\RequestBaseTest::testCookieEmpty
     * @covers  Lunr\Corona\Request::store_cookie
     */
    public function testSuperglobalCookieEmptyAfterStore()
    {
        $stored = $this->reflection_request->getProperty('cookie');
        $stored->setAccessible(TRUE);

        $method = $this->reflection_request->getMethod('store_cookie');
        $method->setAccessible(TRUE);

        $_COOKIE['test1'] = 'value1';
        $_COOKIE['test2'] = 'value2';

        $method->invoke($this->request);

        $this->assertEmpty($_COOKIE);
    }

    /**
     * Test storing invalid $_POST values.
     *
     * @param mixed $post Invalid $_POST values
     *
     * @depends      Lunr\Corona\Tests\RequestBaseTest::testPostEmpty
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\Request::store_post
     */
    public function testStoreInvalidPostValuesLeavesLocalPostEmpty($post)
    {
        $stored = $this->reflection_request->getProperty('post');
        $stored->setAccessible(TRUE);

        $method = $this->reflection_request->getMethod('store_post');
        $method->setAccessible(TRUE);

        $_POST = $post;

        $method->invoke($this->request);

        $this->assertEmpty($stored->getValue($this->request));
    }

    /**
    * Test storing invalid $_POST values.
    *
    * Checks whether the superglobal $_POST is reset to being empty after
    * passing invalid $_POST values in it.
    *
    * @param mixed $post Invalid $_POST values
    *
    * @depends      Lunr\Corona\Tests\RequestBaseTest::testPostEmpty
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_post
    */
    public function testStoreInvalidPostValuesResetsSuperglobalPost($post)
    {
        $method = $this->reflection_request->getMethod('store_post');
        $method->setAccessible(TRUE);

        $_POST = $post;

        $method->invoke($this->request);

        $this->assertEmpty($_POST);
    }

    /**
     * Test storing valid $_POST values.
     *
     * @depends      Lunr\Corona\Tests\RequestBaseTest::testPostEmpty
     * @covers       Lunr\Corona\Request::store_post
     */
    public function testStoreValidPostValues()
    {
        $stored = $this->reflection_request->getProperty('post');
        $stored->setAccessible(TRUE);

        $method = $this->reflection_request->getMethod('store_post');
        $method->setAccessible(TRUE);

        $_POST['test1'] = 'value1';
        $_POST['test2'] = 'value2';
        $cache          = $_POST;

        $method->invoke($this->request);

        $this->assertEquals($cache, $stored->getValue($this->request));
    }

    /**
     * Test that $_POST is empty after storing.
     *
     * @depends Lunr\Corona\Tests\RequestBaseTest::testPostEmpty
     * @covers  Lunr\Corona\Request::store_post
     */
    public function testSuperglobalPostEmptyAfterStore()
    {
        $stored = $this->reflection_request->getProperty('post');
        $stored->setAccessible(TRUE);

        $method = $this->reflection_request->getMethod('store_post');
        $method->setAccessible(TRUE);

        $_POST['test1'] = 'value1';
        $_POST['test2'] = 'value2';

        $method->invoke($this->request);

        $this->assertEmpty($_POST);
    }

    /**
     * Test that the base_path is constructed and stored correctly.
     *
     * @runInSeparateProcess
     * @covers Lunr\Corona\Request::store_url
     */
    public function testStoreBasePath()
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);

        $this->set_request_sapi_non_cli($stored);

        $method = $this->reflection_request->getMethod('store_url');
        $method->setAccessible(TRUE);

        $_SERVER = $this->setup_server_superglobal();

        $method->invokeArgs($this->request, array(&$this->configuration));

        $request = $stored->getValue($this->request);

        $this->assertEquals('/path/to/', $request['base_path']);
    }

    /**
     * Test that the domain is stored correctly.
     *
     * @runInSeparateProcess
     * @covers Lunr\Corona\Request::store_url
     */
    public function testStoreDomain()
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);

        $this->set_request_sapi_non_cli($stored);

        $method = $this->reflection_request->getMethod('store_url');
        $method->setAccessible(TRUE);

        $_SERVER = $this->setup_server_superglobal();

        $method->invokeArgs($this->request, array(&$this->configuration));

        $request = $stored->getValue($this->request);

        $this->assertEquals('www.domain.com', $request['domain']);
    }

    /**
     * Test that the port is stored correctly.
     *
     * @runInSeparateProcess
     * @covers Lunr\Corona\Request::store_url
     */
    public function testStorePort()
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);

        $this->set_request_sapi_non_cli($stored);

        $method = $this->reflection_request->getMethod('store_url');
        $method->setAccessible(TRUE);

        $_SERVER = $this->setup_server_superglobal();

        $method->invokeArgs($this->request, array(&$this->configuration));

        $request = $stored->getValue($this->request);

        $this->assertEquals('443', $request['port']);
    }

    /**
     * Test that the protocol is constructed and stored correctly.
     *
     * @runInSeparateProcess
     * @covers Lunr\Corona\Request::store_url
     */
    public function testStorePortIfHttpsUnset()
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);

        $this->set_request_sapi_non_cli($stored);

        $method = $this->reflection_request->getMethod('store_url');
        $method->setAccessible(TRUE);

        $_SERVER = $this->setup_server_superglobal();
        unset($_SERVER['HTTPS']);

        $method->invokeArgs($this->request, array(&$this->configuration));

        $request = $stored->getValue($this->request);

        $this->assertEquals('http', $request['protocol']);
    }

    /**
     * Test that the protocol is constructed and stored correctly.
     *
     * @param String $value    HTTPS value
     * @param String $protocol Protocol according to the HTTPS value
     *
     * @runInSeparateProcess
     *
     * @dataProvider httpsServerSuperglobalValueProvider
     * @covers Lunr\Corona\Request::store_url
     */
    public function testStorePortIfHttpsIsset($value, $protocol)
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);

        $this->set_request_sapi_non_cli($stored);

        $method = $this->reflection_request->getMethod('store_url');
        $method->setAccessible(TRUE);

        $_SERVER          = $this->setup_server_superglobal();
        $_SERVER['HTTPS'] = $value;

        $method->invokeArgs($this->request, array(&$this->configuration));

        $request = $stored->getValue($this->request);

        $this->assertEquals($protocol, $request['protocol']);
    }

    /**
     * Test that the protocol is constructed and stored correctly.
     *
     * @param String $https HTTPS value
     * @param String $port  Port for the webserver
     * @param String $value The expected base_url value
     *
     * @runInSeparateProcess
     *
     * @dataProvider baseurlProvider
     * @covers Lunr\Corona\Request::store_url
     */
    public function testStoreBaseUrl($https, $port, $value)
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);

        $this->set_request_sapi_non_cli($stored);

        $method = $this->reflection_request->getMethod('store_url');
        $method->setAccessible(TRUE);

        $_SERVER                = $this->setup_server_superglobal();
        $_SERVER['HTTPS']       = $https;
        $_SERVER['SERVER_PORT'] = $port;

        $method->invokeArgs($this->request, array(&$this->configuration));

        $request = $stored->getValue($this->request);

        $this->assertEquals($value, $request['base_url']);
    }

    /**
     * Test storing invalid $_GET values.
     *
     * After providing invalid get values to the store_get function, it checks
     * whether the get property is empty.
     *
     * @param mixed $get Invalid $_GET values
     *
     * @depends      Lunr\Corona\Tests\RequestBaseTest::testGetEmpty
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\Request::store_get
     */
    public function testStoreInvalidGetValuesLeavesGetPropertyEmpty($get)
    {
        $stored = $this->reflection_request->getProperty('get');
        $stored->setAccessible(TRUE);

        $method = $this->reflection_request->getMethod('store_get');
        $method->setAccessible(TRUE);

        $_GET = $get;

        $method->invokeArgs($this->request, array(&$this->configuration));

        $this->assertEmpty($stored->getValue($this->request));
    }

    /**
    * Test storing invalid $_GET values.
    *
    * After providing invalid get values to the store_get function, it checks
    * whether the global GET is reset to being empty.
    *
    * @param mixed $get Invalid $_GET values
    *
    * @depends      Lunr\Corona\Tests\RequestBaseTest::testGetEmpty
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_get
    */
    public function testStoreInvalidGetValuesResetsSuperglobalGet($get)
    {
        $method = $this->reflection_request->getMethod('store_get');
        $method->setAccessible(TRUE);

        $_GET = $get;

        $method->invokeArgs($this->request, array(&$this->configuration));

        $this->assertEmpty($_GET);
    }

    /**
    * Test storing invalid $_GET values.
    *
    * After providing invalid get values to the store_get function, it checks
    * whether the method and controller fields have the default values and the
    * params array is empty.
    *
    * @param mixed $get Invalid $_GET values
    *
    * @depends      Lunr\Corona\Tests\RequestBaseTest::testGetEmpty
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_get
    */
    public function testStoreInvalidGetValuesGetsDefaultControllerAndMethodWithEmptyParams($get)
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);

        $method = $this->reflection_request->getMethod('store_get');
        $method->setAccessible(TRUE);

        $_GET = $get;

        $method->invokeArgs($this->request, array(&$this->configuration));

        $request = $stored->getValue($this->request);

        $this->assertEquals('DefaultController', $request['controller']);
        $this->assertEquals('default_method', $request['method']);
        $this->assertEmpty($request['params']);
    }

    /**
    * Test storing invalid $_GET values.
    *
    * If we have default values for controller and method, construct the
    * call value.
    *
    * @param mixed $get Invalid $_GET values
    *
    * @depends      Lunr\Corona\Tests\RequestBaseTest::testGetEmpty
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_get
    */
    public function testStoreInvalidGetValuesStoresCallIfDefaultsSet($get)
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);

        $method = $this->reflection_request->getMethod('store_get');
        $method->setAccessible(TRUE);

        $_GET = $get;

        $method->invokeArgs($this->request, array(&$this->configuration));

        $request = $stored->getValue($this->request);

        $call = 'DefaultController/default_method';

        $this->assertEquals($call, $request['call']);
    }

    /**
    * Test storing invalid $_GET values.
    *
    * If we don't have default values for controller and method, skip
    * construction of the call value.
    *
    * @param mixed $get Invalid $_GET values
    *
    * @depends      Lunr\Corona\Tests\RequestBaseTest::testGetEmpty
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_get
    */
    public function testStoreInvalidGetValuesDoesNotStoreCallIfDefaultsNotSet($get)
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);
        $stored->setValue($this->request, array());

        $method = $this->reflection_request->getMethod('store_get');
        $method->setAccessible(TRUE);

        $_GET = $get;

        $configuration = $this->getMock('Lunr\Core\Configuration');

        $method->invokeArgs($this->request, array($configuration));

        $request = $stored->getValue($this->request);

        $this->assertNull($request['call']);
    }

    /**
     * Test storing valid $_GET values.
     *
     * @depends      Lunr\Corona\Tests\RequestBaseTest::testGetEmpty
     * @covers       Lunr\Corona\Request::store_get
     */
    public function testStoreValidGetValues()
    {
        $stored = $this->reflection_request->getProperty('get');
        $stored->setAccessible(TRUE);

        $method = $this->reflection_request->getMethod('store_get');
        $method->setAccessible(TRUE);

        $_GET['test1'] = 'value1';
        $_GET['test2'] = 'value2';
        $cache         = $_GET;

        $method->invokeArgs($this->request, array(&$this->configuration));

        $this->assertEquals($cache, $stored->getValue($this->request));
    }

    /**
     * Test storing special $_GET values.
     *
     * @depends      Lunr\Corona\Tests\RequestBaseTest::testGetEmpty
     * @covers       Lunr\Corona\Request::store_get
     */
    public function testStoreSpecialGetValues()
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);
        $stored->setValue($this->request, array());

        $method = $this->reflection_request->getMethod('store_get');
        $method->setAccessible(TRUE);

        $_GET['controller'] = 'controller';
        $_GET['method']     = 'method';
        $_GET['param1']     = 'param1';
        $_GET['param2']     = 'param2';
        $cache              = $_GET;
        $call               = 'controller/method';

        $method->invokeArgs($this->request, array(&$this->configuration));

        $request = $stored->getValue($this->request);
        $this->assertEquals($cache['controller'], $request['controller']);
        $this->assertEquals($cache['method'], $request['method']);
        $this->assertEquals($cache['param1'], $request['params'][0]);
        $this->assertEquals($cache['param2'], $request['params'][1]);
        $this->assertEquals($call, $request['call']);
    }

    /**
     * Test storing special $_GET values, if they are not present.
     *
     * @depends      Lunr\Corona\Tests\RequestBaseTest::testGetEmpty
     * @covers       Lunr\Corona\Request::store_get
     */
    public function testStoreSpecialGetValuesIfNotSet()
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);
        $stored->setValue($this->request, array());

        $method = $this->reflection_request->getMethod('store_get');
        $method->setAccessible(TRUE);

        $_GET['test1'] = 'value1';
        $_GET['test2'] = 'value2';
        $call          = 'DefaultController/default_method';

        $method->invokeArgs($this->request, array(&$this->configuration));

        $request = $stored->getValue($this->request);
        $this->assertEquals('DefaultController', $request['controller']);
        $this->assertEquals('default_method', $request['method']);
        $this->assertInternalType('array', $request['params']);
        $this->assertEmpty($request['params']);
        $this->assertEquals($call, $request['call']);
    }

    /**
     * Test storing the call value if default values are not set.
     *
     * @depends      Lunr\Corona\Tests\RequestBaseTest::testGetEmpty
     * @covers       Lunr\Corona\Request::store_get
     */
    public function testStoreCallIfDefaultsNotSet()
    {
        $stored = $this->reflection_request->getProperty('request');
        $stored->setAccessible(TRUE);
        $stored->setValue($this->request, array());

        $method = $this->reflection_request->getMethod('store_get');
        $method->setAccessible(TRUE);

        $_GET['test1'] = 'value1';
        $_GET['test2'] = 'value2';

        $configuration = $this->getMock('Lunr\Core\Configuration');

        $method->invokeArgs($this->request, array($configuration));

        $request = $stored->getValue($this->request);
        $this->assertNull($request['call']);
    }

    /**
     * Test that $_GET is empty after storing.
     *
     * @depends Lunr\Corona\Tests\RequestBaseTest::testGetEmpty
     * @covers  Lunr\Corona\Request::store_get
     */
    public function testSuperglobalGetEmptyAfterStore()
    {
        $stored = $this->reflection_request->getProperty('get');
        $stored->setAccessible(TRUE);

        $method = $this->reflection_request->getMethod('store_get');
        $method->setAccessible(TRUE);

        $_GET['test1'] = 'value1';
        $_GET['test2'] = 'value2';

        $method->invokeArgs($this->request, array(&$this->configuration));

        $this->assertEmpty($_GET);
    }

}

?>
