<?php

/**
 * This file contains the MySQLConnectionTest class.
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

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\MySQLConnection;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the MySQLConnection class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\MySQLConnection
 */
abstract class MySQLConnectionTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the MySQLConnection class.
     * @var MySQLConnection
     */
    protected $db;

    /**
     * Reflection instance of the MySQLConnection class.
     * @var ReflectionClass
     */
    protected $db_reflection;

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
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the mysqli class.
     * @var mysqli
     */
    protected $mysqli;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function emptySetUp()
    {
        $this->sub_configuration = $this->getMock('Lunr\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $map = array(
            array('db', $this->sub_configuration),
        );

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->mysqli = $this->getMock('\mysqli');

        $this->db = new MySQLConnection($this->configuration, $this->logger, $this->mysqli);

        $this->db_reflection = new ReflectionClass('Lunr\DataAccess\MySQLConnection');
    }

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->sub_configuration = $this->getMock('Lunr\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Core\Configuration');

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

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->mysqli = $this->getMock('\mysqli');

        $this->db = new MySQLConnection($this->configuration, $this->logger, $this->mysqli);

        $this->db_reflection = new ReflectionClass('Lunr\DataAccess\MySQLConnection');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->db);
        unset($this->db_reflection);
        unset($this->configuration);
        unset($this->logger);
    }

    /**
     * Unit Test Data Provider for strings to escape.
     *
     * @return array $strings Array of strings and their expected escaped value
     */
    public function escapeStringProvider()
    {
        $strings   = array();
        $strings[] = array("'--", "\'--", "\'--");
        $strings[] = array("\'--", "\\\'--", "\\\'--");
        $strings[] = array('70%', '70%', '70\%');
        $strings[] = array('test_name', 'test_name', 'test\_name');

        return $strings;
    }

}

?>
