<?php

/**
 * This file contains the CliRequestTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

use Lunr\Shadow\CliRequest;
use Lunr\Halo\LunrBaseTest;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the CliRequest class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Shadow\CliRequest
 */
abstract class CliRequestTest extends LunrBaseTest
{

    /**
     * Configuration class instance.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Runkit simulation code for getting the hostname.
     * @var string
     */
    const GET_HOSTNAME = 'return "Lunr";';

    /**
     * TestCase Constructor.
     */
    public function setUp()
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

        $ast = array(
            'f'        => array('value for f'),
            'v'        => array(),
            'a'        => array(),
            'required' => array(array('value1', 'value2', 'value3')),
            'optional' => array('optional value'),
            'option'   => array()
        );

        $parser = $this->getMockBuilder('Lunr\Shadow\GetoptCliParser')
                       ->disableOriginalConstructor()
                       ->getMock();

        $parser->expects($this->any())
               ->method('parse')
               ->will($this->returnValue($ast));

        $this->class         = new CliRequest($configuration, $parser);
        $this->reflection    = new ReflectionClass('Lunr\Shadow\CliRequest');
        $this->configuration = $configuration;
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
     * Unit Test Data Provider for valid json enums.
     *
     * @return array $json Set of valid json enums
     */
    public function validJsonEnumProvider()
    {
        $json   = array();
        $json[] = array('a_value', 'a');
        $json[] = array('very_long_value', 'v');
        $json[] = array('fery_long_value', 'f');

        return $json;
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
     * Unit test Data Provider for valid AST values.
     *
     * @return array $values Set of AST key value pair
     */
    public function validAstValueProvider()
    {
        $values   = array();
        $values[] = array(array());
        $values[] = array(array(array(FALSE, FALSE)));
        $values[] = array(array('test'));
        $values[] = array(array('test', 'test1'));

        return $values;
    }

    /**
     * Unit Test Data provider for ast keys.
     *
     * @return array $values Set ast keys
     */
    public function astKeyProvider()
    {
        $values   = array();
        $values[] = array(array());
        $values[] = array(array('a'));
        $values[] = array(array('a', 'b'));

        return $values;
    }

}

?>
