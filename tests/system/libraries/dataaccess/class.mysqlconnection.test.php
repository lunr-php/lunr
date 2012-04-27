<?php

/**
 * This file contains the MySQLConnectionTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\DataAccess;
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
 * @covers     Lunr\Libraries\DataAccess\MySQLConnection
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
     * @var Logger
     */
    protected $logger;

    /**
     * TestCase Constructor.
     */
    public function emptySetUp()
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

        $this->db = new MySQLConnection($this->configuration, $this->logger, $this->getMock('\mysqli'));

        $this->db_reflection = new ReflectionClass('Lunr\Libraries\DataAccess\MySQLConnection');
    }

    /**
     * TestCase Constructor.
     */
    public function SetUp()
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

        $this->db = new MySQLConnection($this->configuration, $this->logger, $this->getMock('\mysqli'));

        $this->db_reflection = new ReflectionClass('Lunr\Libraries\DataAccess\MySQLConnection');
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

}

?>
