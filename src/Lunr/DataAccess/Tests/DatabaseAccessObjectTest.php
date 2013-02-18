<?php

/**
 * This file contains the DatabaseAccessObjectTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\DatabaseAccessObject;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains the tests for the DatabaseAccessObject class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\DatabaseAccessObject
 */
abstract class DatabaseAccessObjectTest extends PHPUnit_Framework_TestCase
{

    /**
     * Mock instance of the DatabaseConnectionPool
     * @var DatabaseConnectionPool
     */
    protected $pool;

    /**
     * Mock instance of a DatabaseConnection
     * @var DatabaseConnection
     */
    protected $db;

    /**
     * Mock instance of the Logger class.
     * @var Logger
     */
    protected $logger;

    /**
     * Instance of the DatabaseAccessObject
     * @var DatabaseAccessObject
     */
    protected $dao;

    /**
     * Reflection instance of the DatabaseAccessObject
     * @var ReflectionClass
     */
    protected $reflection_dao;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpNoPool()
    {
        $this->pool = NULL;

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->db = $this->getMockBuilder('Lunr\DataAccess\MySQLConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->dao = $this->getMockBuilder('Lunr\DataAccess\DatabaseAccessObject')
                          ->setConstructorArgs(array($this->db, $this->logger))
                          ->getMockForAbstractClass();

        $this->reflection_dao = new ReflectionClass('Lunr\DataAccess\DatabaseAccessObject');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpPool()
    {
        $this->pool = $this->getMockBuilder('Lunr\DataAccess\DatabaseConnectionPool')
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->db = $this->getMockBuilder('Lunr\DataAccess\MySQLConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->dao = $this->getMockBuilder('Lunr\DataAccess\DatabaseAccessObject')
                          ->setConstructorArgs(array($this->db, $this->logger, $this->pool))
                          ->getMockForAbstractClass();

        $this->reflection_dao = new ReflectionClass('Lunr\DataAccess\DatabaseAccessObject');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->pool);
        unset($this->db);
        unset($this->logger);
        unset($this->dao);
        unset($this->reflection_dao);
    }

}

?>
