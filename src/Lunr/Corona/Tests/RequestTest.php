<?php

/**
 * This file contains the RequestTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Request;
use Lunr\Halo\LunrBaseTest;
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
abstract class RequestTest extends LunrBaseTest
{

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
        $configuration = $this->getMock('Lunr\Core\Configuration');

        $map = [
            [ 'default_controller', 'DefaultController' ],
            [ 'default_method', 'default_method' ]
         ];

        $configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->configuration = $configuration;

        $this->reflection = new ReflectionClass('Lunr\Corona\Request');
    }

    /**
     * TestCase Constructor for filled superglobals.
     *
     * @return void
     */
    public function setUpRunkit()
    {
        if (extension_loaded('runkit') === FALSE)
        {
            $this->markTestSkipped('Extension runkit is required.');
        }

        $this->mock_function('gethostname', self::GET_HOSTNAME);

        $this->setUpFilled();
    }

    /**
     * TestCase Constructor for filled superglobals.
     *
     * @return void
     */
    public function setUpFilled()
    {
        $this->setUpShared();

        $enums  = $this->get_json_enums();
        $_POST  = array_flip($enums);
        $_FILES = [
            'image' => [
                'name' => 'Name',
                'type' => 'Type',
                'tmp_name' => 'Tmp',
                'error' => 'Error',
                'size' => 'Size'
            ]
        ];

        $_GET               = array_flip($enums);
        $_GET['controller'] = 'controller';
        $_GET['method']     = 'method';
        $_GET['param1']     = 'param1';
        $_GET['param2']     = 'param2';

        $_COOKIE              = array_flip($enums);
        $_COOKIE['PHPSESSID'] = 'value';

        $_SERVER = $this->setup_server_superglobal();

        $this->class = new Request($this->configuration);
    }

    /**
     * TestCase Constructor for empty superglobals.
     *
     * @return void
     */
    public function setUpEmpty()
    {
        $this->setUpShared();

        $_POST   = [];
        $_FILES  = [];
        $_GET    = [];
        $_COOKIE = [];

        $_SERVER = $this->setup_server_superglobal();

        $this->class = new Request($this->configuration);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->configuration);
    }

    /**
     * TestCase Destructor.
     *
     * @return void
     */
    public function tearDownRunkit()
    {
        $this->unmock_function('gethostname');

        unset($this->class);
        unset($this->reflection);
        unset($this->configuration);
    }

    /**
     * Unit Test Data Provider for request values.
     *
     * @return array $values Set of request values
     */
    public function requestValueProvider()
    {
        $values   = [];
        $values[] = [ 'protocol', 'https' ];
        $values[] = [ 'domain', 'www.domain.com' ];
        $values[] = [ 'port', '443' ];
        $values[] = [ 'base_path', '/path/to/' ];
        $values[] = [ 'base_url', 'https://www.domain.com/path/to/' ];
        $values[] = [ 'sapi', 'cli' ];
        $values[] = [ 'controller', 'DefaultController' ];
        $values[] = [ 'method', 'default_method' ];
        $values[] = [ 'params', [] ];
        $values[] = [ 'call', 'DefaultController/default_method' ];

        return $values;
    }

    /**
     * Unit Test Data Provider for request values.
     *
     * @return array $values Set of request values
     */
    public function properRequestValueProvider()
    {
        $values   = [];
        $values[] = [ 'protocol', 'https' ];
        $values[] = [ 'domain', 'www.domain.com' ];
        $values[] = [ 'port', '443' ];
        $values[] = [ 'base_path', '/path/to/' ];
        $values[] = [ 'base_url', 'https://www.domain.com/path/to/' ];
        $values[] = [ 'sapi', 'cli' ];
        $values[] = [ 'controller', 'controller' ];
        $values[] = [ 'method', 'method' ];
        $values[] = [ 'params', [ 'param1', 'param2' ] ];
        $values[] = [ 'call', 'controller/method' ];

        return $values;
    }

    /**
     * Unit Test Data Provider for valid json enums.
     *
     * @return array $json Set of valid json enums
     */
    public function validJsonEnumProvider()
    {
        $json   = [];
        $json[] = [ 'long_value', 'lv' ];
        $json[] = [ 'short_value', 'sv' ];

        return $json;
    }

    /**
     * Unit Test Data Provider for invalid global array keys.
     *
     * @return array $keys Set of invalid array keys
     */
    public function invalidKeyProvider()
    {
        $keys   = [];
        $keys[] = [ 'invalid' ];

        return $keys;
    }

    /**
     * Unit Test Data Provider for invalid $_COOKIE values.
     *
     * @return array $cookie Set of invalid $_COOKIE values
     */
    public function invalidSuperglobalValueProvider()
    {
        $values   = [];
        $values[] = [ [] ];
        $values[] = [ 0 ];
        $values[] = [ 'String' ];
        $values[] = [ TRUE ];
        $values[] = [ NULL ];

        return $values;
    }

    /**
     * Unit Test Data Provider for unhandled __get() keys.
     *
     * @return array $keys Array of unhandled key values
     */
    public function unhandledMagicGetKeysProvider()
    {
        $keys   = [];
        $keys[] = [ 'Unhandled' ];

        return $keys;
    }

    /**
     * Unit Test Data Provider for $_SERVER['HTTPS'] values.
     *
     * @return array $https Array of $_SERVER['HTTPS'] values
     */
    public function httpsServerSuperglobalValueProvider()
    {
        $https   = [];
        $https[] = [ 'on', 'https' ];
        $https[] = [ 'off', 'http' ];

        return $https;
    }

    /**
     * Unit Test Data Provider for possible base_url values and parameters.
     *
     * @return array $base Array of base_url parameters and possible values
     */
    public function baseurlProvider()
    {
        $base   = [];
        $base[] = [ 'on', '443', 'https://www.domain.com/path/to/' ];
        $base[] = [ 'on', '80', 'https://www.domain.com:80/path/to/' ];
        $base[] = [ 'off', '80', 'http://www.domain.com/path/to/' ];
        $base[] = [ 'off', '443', 'http://www.domain.com:443/path/to/' ];

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

        $JSON = [];

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
        $array  = [];

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
        $server = [];

        $server['SCRIPT_NAME'] = '/path/to/index.php';
        $server['HTTPS']       = 'on';
        $server['SERVER_NAME'] = 'www.domain.com';
        $server['SERVER_PORT'] = '443';

        return $server;
    }

}

?>
