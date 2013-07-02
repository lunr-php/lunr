<?php

/**
 * This file contains the RequestTest class.
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

use Lunr\Corona\Request;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the DateTime class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Corona\Request
 */
abstract class RequestTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the Request class.
     * @var Request
     */
    protected $request;

    /**
     * Reflection instance of the Request class.
     * @var ReflectionClass
     */
    protected $reflection_request;

    /**
     * Mock of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Runkit simulation code for getting the hostname.
     * @var string
     */
    const GET_HOSTNAME = 'return "Lunr";';

    /**
     * Shared TestCase Constructor code.
     *
     * @return void
     */
    public function setUpShared()
    {
        if (function_exists('runkit_function_redefine'))
        {
            runkit_function_redefine('gethostname', '', self::GET_HOSTNAME);
        }

        $configuration = $this->getMock('Lunr\Core\Configuration');

        $map = array(
            array('default_webpath', '/path'),
            array('default_protocol', 'http'),
            array('default_domain', 'www.domain.com'),
            array('default_port', 666),
            array('default_url', 'http://www.domain.com:666/path/'),
            array('default_controller', 'DefaultController'),
            array('default_method', 'default_method')
        );

        $configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->configuration = $configuration;

        $this->reflection_request = new ReflectionClass('Lunr\Corona\Request');
    }

    /**
     * TestCase Constructor for filled superglobals.
     *
     * @return void
     */
    public function setUpFilled()
    {
        $this->setUpShared();

        $enums = $this->get_json_enums();
        $_POST = array_flip($enums);

        $_GET               = array_flip($enums);
        $_GET['controller'] = 'controller';
        $_GET['method']     = 'method';
        $_GET['param1']     = 'param1';
        $_GET['param2']     = 'param2';

        $_COOKIE = array_flip($enums);

        $_SERVER = $this->setup_server_superglobal();

        $this->request = new Request($this->configuration);

        $this->request->set_json_enums($enums);
    }

    /**
     * TestCase Constructor for empty superglobals.
     *
     * @return void
     */
    public function setUpEmpty()
    {
        $this->setUpShared();

        $_POST   = array();
        $_GET    = array();
        $_COOKIE = array();

        $this->request = new Request($this->configuration);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->request);
        unset($this->reflection_request);
        unset($this->configuration);
    }

    /**
     * Unit Test Data Provider for request values.
     *
     * @return array $values Set of request values
     */
    public function requestValueProvider()
    {
        $values   = array();
        $values[] = array('protocol', 'http');
        $values[] = array('domain', 'www.domain.com');
        $values[] = array('port', '666');
        $values[] = array('base_path', '/path');
        $values[] = array('base_url', 'http://www.domain.com:666/path/');
        $values[] = array('sapi', 'cli');
        $values[] = array('controller', 'DefaultController');
        $values[] = array('method', 'default_method');
        $values[] = array('params', array());
        $values[] = array('call', 'DefaultController/default_method');

        return $values;
    }

    /**
     * Unit Test Data Provider for request values.
     *
     * @return array $values Set of request values
     */
    public function properRequestValueProvider()
    {
        $values   = array();
        $values[] = array('protocol', 'http');
        $values[] = array('domain', 'www.domain.com');
        $values[] = array('port', '666');
        $values[] = array('base_path', '/path');
        $values[] = array('base_url', 'http://www.domain.com:666/path/');
        $values[] = array('sapi', 'cli');
        $values[] = array('controller', 'controller');
        $values[] = array('method', 'method');
        $values[] = array('params', array('param1', 'param2'));
        $values[] = array('call', 'controller/method');

        return $values;
    }

    /**
     * Unit Test Data Provider for valid json enums.
     *
     * @return array $json Set of valid json enums
     */
    public function validJsonEnumProvider()
    {
        $json   = array();
        $json[] = array('long_value', 'lv');
        $json[] = array('short_value', 'sv');

        return $json;
    }

    /**
     * Unit Test Data Provider for invalid global array keys.
     *
     * @return array $keys Set of invalid array keys
     */
    public function invalidKeyProvider()
    {
        $keys   = array();
        $keys[] = array('invalid');

        return $keys;
    }

    /**
     * Unit Test Data Provider for invalid $_COOKIE values.
     *
     * @return array $cookie Set of invalid $_COOKIE values
     */
    public function invalidSuperglobalValueProvider()
    {
        $values   = array();
        $values[] = array(array());
        $values[] = array(0);
        $values[] = array('String');
        $values[] = array(TRUE);
        $values[] = array(NULL);

        return $values;
    }

    /**
     * Unit Test Data Provider for unhandled __get() keys.
     *
     * @return array $keys Array of unhandled key values
     */
    public function unhandledMagicGetKeysProvider()
    {
        $keys   = array();
        $keys[] = array('Unhandled');

        return $keys;
    }

    /**
     * Unit Test Data Provider for $_SERVER['HTTPS'] values.
     *
     * @return array $https Array of $_SERVER['HTTPS'] values
     */
    public function httpsServerSuperglobalValueProvider()
    {
        $https   = array();
        $https[] = array('on', 'https');
        $https[] = array('off', 'http');

        return $https;
    }

    /**
     * Unit Test Data Provider for possible base_url values and parameters.
     *
     * @return array $base Array of base_url parameters and possible values
     */
    public function baseurlProvider()
    {
        $base   = array();
        $base[] = array('on', '443', 'https://www.domain.com/path/to/');
        $base[] = array('on', '80', 'https://www.domain.com:80/path/to/');
        $base[] = array('off', '80', 'http://www.domain.com/path/to/');
        $base[] = array('off', '443', 'http://www.domain.com:443/path/to/');

        return $base;
    }

    /**
     * Get a set of JSON enums.
     *
     * @return array $json Set of json enums
     */
    public function get_json_enums()
    {
        $raw = $this->validJsonEnumProvider();

        $JSON = array();

        foreach ($raw as $set)
        {
            $JSON[$set[0]] = $set[1];
        }

        return $JSON;
    }

    /**
     * Check whether the request values are as expected.
     *
     * @param array $request_values Array of actual request values
     *
     * @return Boolean $return TRUE if it matches the default, FALSE otherwise
     */
    public function check_default_request_values($request_values)
    {
        $values = $this->requestValueProvider();
        $array  = array();

        foreach ($values as $value)
        {
            $array[$value[0]] = $value[1];
        }

        if ($array === $request_values)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Set up the $_SERVER superglobal for our tests.
     *
     * @return array $server Stripped down $_SERVER variable
     */
    protected function setup_server_superglobal()
    {
        $server = array();

        $server['SCRIPT_NAME'] = '/path/to/index.php';
        $server['HTTPS']       = 'on';
        $server['SERVER_NAME'] = 'www.domain.com';
        $server['SERVER_PORT'] = '443';

        return $server;
    }

    /**
     * Set the stored sapi value to 'apache'.
     *
     * @param ReflectionProperty &$reflection_property Reference to the ReflectionProperty class
     *                                                 for the private request attribute
     *
     * @return void
     */
    protected function set_request_sapi_non_cli(&$reflection_property)
    {
        $reflection_property->setAccessible(TRUE);
        $request         = $reflection_property->getValue($this->request);
        $request['sapi'] = 'apache';

        $reflection_property->setValue($this->request, $request);
    }

}

?>
