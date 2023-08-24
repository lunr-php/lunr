<?php

/**
 * This file contains the AbstractMySQLDatabaseAccessObjectTest class.
 *
 * @package    Lunr\Halo
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests\Helpers;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;
use Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder;
use Lunr\Gravity\Database\MySQL\MySQLQueryEscaper;
use Lunr\Gravity\Database\Tests\Helpers\DatabaseAccessObjectBaseTest;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;

/**
 * This class contains setup and tear down methods for DAOs using MySQL access.
 */
abstract class AbstractMySQLDatabaseAccessObjectTest extends DatabaseAccessObjectBaseTest
{

    /**
     * Mock instance of the MySQLConnection class.
     * @var \Lunr\Gravity\Database\MySQL\MySQLConnection|MockObject
     */
    protected $db;

    /**
     * Mock instance of the Logger class
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the DMLQueryBuilder class
     * @var \Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder|MockObject
     */
    protected $builder;

    /**
     * Real instance of the DMLQueryBuilder class
     * @var \Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
     */
    protected $real_builder;

    /**
     * Real instance of the SimpleDMLQueryBuilder class
     * @var \Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder
     */
    protected $real_simple_builder;

    /**
     * Mock instance of the QueryEscaper class
     * @var \Lunr\Gravity\Database\MySQL\MySQLQueryEscaper|MockObject
     */
    protected $escaper;

    /**
     * Real instance of the QueryEscaper class
     * @var \Lunr\Gravity\Database\MySQL\MySQLQueryEscaper
     */
    protected $real_escaper;

    /**
     * Mock instance of the QueryResult class
     * @var \Lunr\Gravity\Database\MySQL\MySQLQueryResult
     */
    protected $result;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $mock_escaper = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseStringEscaperInterface')
                             ->getMock();

        $mock_escaper->expects($this->any())
                     ->method('escape_string')
                     ->willReturnArgument(0);

        $this->real_builder = new MySQLDMLQueryBuilder();
        $this->real_escaper = new MySQLQueryEscaper($mock_escaper);

        $this->real_simple_builder = new MySQLSimpleDMLQueryBuilder($this->real_builder, $this->real_escaper);

        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->builder = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->escaper = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->result = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->db->expects($this->exactly(1))
                 ->method('get_query_escaper_object')
                 ->will($this->returnValue($this->escaper));

        // Assumption: All DAO's end in DAO.
        $name = str_replace('\\Tests\\', '\\', substr(static::class, 0, strrpos(static::class, 'DAO') + 3));

        $this->class = $this->getMockBuilder($name)
                            ->setConstructorArgs([ $this->db, $this->logger ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass($name);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->db);
        unset($this->logger);
        unset($this->builder);
        unset($this->escaper);
        unset($this->result);
        unset($this->real_escaper);
        unset($this->real_builder);
        unset($this->real_simple_builder);
    }

}

?>
