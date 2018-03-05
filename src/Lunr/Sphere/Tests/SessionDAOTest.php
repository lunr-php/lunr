<?php

/**
 * This file contains the SessionDAOTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Sphere
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere\Tests;

use Lunr\Sphere\SessionDAO;
use Lunr\Gravity\Database\MySQL\Tests\MockMySQLiResult;
use Lunr\Gravity\Database\MySQL\Tests\MockMySQLiSuccessfulConnection;
use Lunr\Halo\LunrBaseTest;
use Psr\Log\LoggerInterface;
use \ReflectionClass;
use \stdClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the SessionDAO class.
 *
 * @covers Lunr\Sphere\SessionDAO
 */
class SessionDAOTest extends LunrBaseTest
{

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of the LoggerInterface.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the DatabaseConnection class.
     * @var DatabaseConnection
     */
    protected $db;

    /**
     * Mock instance of the DatabaseConnection class.
     * @var MySQLDMLQueryBuilder
     */
    protected $query_builder;

    /**
     * Mock instance of the QueryEscaper class.
     * @var MySQLQueryEscaper
     */
    protected $escaper;

    /**
     * Query string.
     * @var String
     */
    protected $query;

    /**
     * Mock instance of the DatabaseConnection class.
     * @var DatabaseQueryResultInterface
     */
    protected $query_result;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $mysqli_mock        = new MockMySQLiSuccessfulConnection($this->getMockBuilder('\mysqli')->getMock());
        $mysqli_result_mock = new MockMySQLiResult($this->getMockBuilder('mysqli_result')
                                                        ->disableOriginalConstructor()
                                                        ->getMock());

        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->query_builder = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder')
                                    ->setConstructorArgs(array($this->db))
                                    ->getMock();

        $this->escaper = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->db->expects($this->once())
                 ->method('get_query_escaper_object')
                 ->will($this->returnValue($this->escaper));

        $this->query = 'SELECT * FROM table';

        $this->query_result = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->class      = new SessionDAO($this->db, $this->logger);
        $this->reflection = new ReflectionClass('Lunr\Sphere\SessionDAO');

    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->configuration);
        unset($this->logger);
        unset($this->db);
        unset($this->query_builder);
        unset($this->escaper);
        unset($this->query);
        unset($this->query_result);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
