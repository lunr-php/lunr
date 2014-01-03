<?php

/**
 * This file contains the DatabaseAccessObjectTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseAccessObject;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains the tests for the DatabaseAccessObject class.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseAccessObject
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

        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $escaper = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper')
                        ->disableOriginalConstructor()
                        ->getMock();

        $this->db->expects($this->once())
                 ->method('get_query_escaper_object')
                 ->will($this->returnValue($escaper));

        $this->dao = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseAccessObject')
                          ->setConstructorArgs(array($this->db, $this->logger))
                          ->getMockForAbstractClass();

        $this->reflection_dao = new ReflectionClass('Lunr\Gravity\Database\DatabaseAccessObject');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpPool()
    {
        $this->pool = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseConnectionPool')
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $escaper = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper')
                        ->disableOriginalConstructor()
                        ->getMock();

        $this->db->expects($this->once())
                 ->method('get_query_escaper_object')
                 ->will($this->returnValue($escaper));

        $this->dao = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseAccessObject')
                          ->setConstructorArgs(array($this->db, $this->logger, $this->pool))
                          ->getMockForAbstractClass();

        $this->reflection_dao = new ReflectionClass('Lunr\Gravity\Database\DatabaseAccessObject');
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
