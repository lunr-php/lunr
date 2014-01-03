<?php

/**
 * This file contains the ResqueRequestTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn\Tests;

use Lunr\Spawn\ResqueRequest;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the ResqueRequest class.
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spawn\ResqueRequest
 */
abstract class ResqueRequestTest extends LunrBaseTest
{

    /**
     * Mock of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Shared TestCase Constructor code.
     *
     * @return void
     */
    public function setUp()
    {
        $configuration = $this->getMock('Lunr\Core\Configuration');

        $map = [
            [ 'default_webpath', '/path' ],
            [ 'default_domain', 'www.domain.com' ],
            [ 'default_port', 666 ],
            [ 'default_url', 'http://www.domain.com:666/path/' ],
         ];

        $configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->configuration = $configuration;

        $this->class      = new ResqueRequest($this->configuration);
        $this->reflection = new ReflectionClass('Lunr\Spawn\ResqueRequest');
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
        $values   = [];
        $values[] = [ 'protocol', 'resque' ];
        $values[] = [ 'domain', 'www.domain.com' ];
        $values[] = [ 'port', '666' ];
        $values[] = [ 'base_path', '/path' ];
        $values[] = [ 'base_url', 'http://www.domain.com:666/path/' ];
        $values[] = [ 'sapi', 'cli' ];
        $values[] = [ 'controller', 'resque' ];
        $values[] = [ 'method', '' ];
        $values[] = [ 'params', [] ];
        $values[] = [ 'call', 'resque/' ];

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
        $values[] = [ 'protocol', 'resque' ];
        $values[] = [ 'domain', 'www.domain.com' ];
        $values[] = [ 'port', '666' ];
        $values[] = [ 'base_path', '/path' ];
        $values[] = [ 'base_url', 'http://www.domain.com:666/path/' ];
        $values[] = [ 'sapi', 'cli' ];
        $values[] = [ 'controller', 'resque' ];
        $values[] = [ 'method', '' ];
        $values[] = [ 'params', [ ] ];
        $values[] = [ 'call', 'resque/' ];

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

}

?>
