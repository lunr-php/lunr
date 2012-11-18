<?php

/**
 * This file contains the DatabaseConnectionPoolTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the DatabaseConnectionPool class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\DatabaseConnectionPool
 */
abstract class DatabaseConnectionPoolTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the DatabaseConnectionPool class.
     * @var DatabaseConnectionPool
     */
    protected $pool;

    /**
     * Reflection instance of the DatabaseConnectionPool class.
     * @var ReflectionClass
     */
    protected $pool_reflection;

    /**
     * Mock instance of the sub Configuration class.
     * @var Configuration
     */
    protected $sub_configuration;

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of the Logger class.
     * @var Logger
     */
    protected $logger;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function emptySetup()
    {
        $this->sub_configuration = $this->getMock('Lunr\Libraries\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Libraries\Core\Configuration');

        $map = array(
            array('db', $this->sub_configuration),
        );

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Lunr\Libraries\Core\Logger')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->pool = new DatabaseConnectionPool($this->configuration, $this->logger);

        $this->pool_reflection = new ReflectionClass('Lunr\Libraries\DataAccess\DatabaseConnectionPool');
    }

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function unsupportedSetup()
    {
        $this->sub_configuration = $this->getMock('Lunr\Libraries\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Libraries\Core\Configuration');

        $map = array(
            array('db', $this->sub_configuration),
        );

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('driver', 'unsupported')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Lunr\Libraries\Core\Logger')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->pool = new DatabaseConnectionPool($this->configuration, $this->logger);

        $this->pool_reflection = new ReflectionClass('Lunr\Libraries\DataAccess\DatabaseConnectionPool');
    }

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function supportedSetup()
    {
        $this->sub_configuration = $this->getMock('Lunr\Libraries\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Libraries\Core\Configuration');

        $map = array(
            array('db', $this->sub_configuration),
        );

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Lunr\Libraries\Core\Logger')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->pool = new DatabaseConnectionPool($this->configuration, $this->logger);

        $this->pool_reflection = new ReflectionClass('Lunr\Libraries\DataAccess\DatabaseConnectionPool');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->pool);
        unset($this->pool_reflection);
        unset($this->configuration);
        unset($this->logger);
    }

}

?>
