<?php

/**
 * This file contains the SessionDAOTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use stdClass;
use Lunr\Core\SessionDAO;
use Psr\Log\LoggerInterface;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the SessionDAO class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Core\SessionDAO
 */
class SessionDAOTest extends PHPUnit_Framework_TestCase
{

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    private $configuration;

    /**
     * Mock instance of the LoggerInterface.
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Mock instance of the DatabaseConnection class.
     * @var DatabaseConnection
     */
    private $db;

    /**
     * Mock instance of the DatabaseConnection class.
     * @var MySQLDMLQueryBuilder
     */
    private $query_builder;

    /**
     * Mock instance of the DatabaseConnection class.
     * @var DatabaseQueryResultInterface
     */
    private $query_result;

    /**
     * Instance of the SessionDAO class.
     * @var SessionDAO
     */
    private $session_dao;

    /**
     * Reflection instance of the SessionDAO class.
     * @var ReflectionClass
     */
    private $session_dao_reflection;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $mysqli_mock = $this->getMock('MySQLi');
        $mysqli_result_mock = $this->getMockBuilder('mysqli_result')
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->db = $this->getMockBuilder('Lunr\DataAccess\MySQLConnection')
                         ->setConstructorArgs(array(&$this->configuration, &$this->logger, $mysqli_mock))
                         ->getMock();

        $this->query_builder = $this->getMockBuilder('Lunr\DataAccess\MySQLDMLQueryBuilder')
                                    ->setConstructorArgs(array(&$this->db))
                                    ->getMock();

        $this->query_result = $this->getMockBuilder('Lunr\DataAccess\MySQLQueryResult')
                                   ->setConstructorArgs(array($mysqli_result_mock, $mysqli_mock))
                                   ->getMock();

        $this->session_dao            = new SessionDAO($this->db);
        $this->session_dao_reflection = new ReflectionClass('Lunr\Core\SessionDAO');

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
        unset($this->query_result);
        unset($this->session_dao);
        unset($this->session_dao_reflection);

    }

    /**
     * Test that Read Session Data returns false if there is no session.
     *
     * @covers     Lunr\Core\SessionDAO::read_session_data
     */
    public function testReadSessionDataReturnsFalseIfSessionNotExists()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));

        $this->query_builder->expects($this->once())
                 ->method('result_column')
                 ->will($this->returnValue('column1'));
        $this->query_builder->expects($this->once())
                 ->method('select')
                 ->with($this->equalTo('column1'));

        $this->query_builder->expects($this->once())
                 ->method('table')
                 ->with($this->equalTo('user_sessions'));
        $this->query_builder->expects($this->once())
                 ->method('from');

        $map_column = array(
            array('sessionID', '', 'sessionID'),
            array('expires', '', 'expires')
        );
        $this->query_builder->expects($this->exactly(2))
                 ->method('column')
                 ->will($this->returnValueMap($map_column));

        $this->query_builder->expects($this->once())
                 ->method('value')
                 ->with($this->equalTo('myId'));
        $this->query_builder->expects($this->exactly(2))
                 ->method('where');

        $this->query_builder->expects($this->once())
                 ->method('get_select_query');
        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->query_result->expects($this->once())
                 ->method('has_failed')
                 ->will($this->returnValue(TRUE));

        $this->assertFalse($this->session_dao->read_session_data('myId'));

    }

    /**
     * Test that Read Session Data returns Session.
     *
     * @covers     Lunr\Core\SessionDAO::read_session_data
     */
    public function testReadSessionDataReturnsSession()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));

        $this->query_builder->expects($this->once())
                 ->method('result_column')
                 ->will($this->returnValue('column1'));
        $this->query_builder->expects($this->once())
                 ->method('select')
                 ->with($this->equalTo('column1'));

        $this->query_builder->expects($this->once())
                 ->method('table')
                 ->with($this->equalTo('user_sessions'));
        $this->query_builder->expects($this->once())
                 ->method('from');

        $map_column = array(
            array('sessionID', '', 'sessionID'),
            array('expires', '', 'expires')
        );
        $this->query_builder->expects($this->exactly(2))
                 ->method('column')
                 ->will($this->returnValueMap($map_column));

        $this->query_builder->expects($this->once())
                 ->method('value')
                 ->with($this->equalTo('myId'));
        $this->query_builder->expects($this->exactly(2))
                 ->method('where');

        $this->query_builder->expects($this->once())
                 ->method('get_select_query');
        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->query_result->expects($this->once())
                 ->method('has_failed')
                 ->will($this->returnValue(FALSE));
        $this->query_result->expects($this->once())
                 ->method('number_of_rows')
                 ->will($this->returnValue(1));
        $this->query_result->expects($this->once())
                 ->method('result_cell')
                 ->will($this->returnValue(base64_encode('mySession')));

        $this->assertEquals($this->session_dao->read_session_data('myId'), 'mySession');

    }

    /**
     * Test that Write Session Data rollsback if there is no session.
     *
     * @covers     Lunr\Core\SessionDAO::write_session_data
     */
    public function testWriteSessionDataRollsBackIfNoSession()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));
        $this->db->expects($this->once())
                 ->method('begin_transaction');

        $this->query_builder->expects($this->once())
                 ->method('lock_mode')
                 ->with($this->equalTo('FOR UPDATE'));

        $this->query_builder->expects($this->once())
                 ->method('table')
                 ->with($this->equalTo('user_sessions'));
        $this->query_builder->expects($this->once())
                 ->method('from');

        $this->query_builder->expects($this->once())
                 ->method('column')
                 ->with($this->equalTo('sessionID'));
        $this->query_builder->expects($this->once())
                 ->method('value')
                 ->with($this->equalTo('myId'));
        $this->query_builder->expects($this->once())
                 ->method('where');

        $this->query_builder->expects($this->once())
                 ->method('get_select_query');
        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->query_result->expects($this->once())
                 ->method('has_failed')
                 ->will($this->returnValue(TRUE));

        $this->db->expects($this->once())
                 ->method('rollback');
        $this->db->expects($this->once())
                 ->method('end_transaction');

        $this->session_dao->write_session_data('myId', 'myData', time());
    }

    /**
     * Test that Write Session Data.
     *
     * @covers     Lunr\Core\SessionDAO::write_session_data
     */
    public function testWriteSessionData()
    {
        $this->db->expects($this->exactly(2))
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));
        $this->db->expects($this->once())
                 ->method('begin_transaction');

        $this->query_builder->expects($this->once())
                 ->method('lock_mode')
                 ->with($this->equalTo('FOR UPDATE'));

        $this->query_builder->expects($this->once())
                 ->method('table')
                 ->with($this->equalTo('user_sessions'));
        $this->query_builder->expects($this->once())
                 ->method('from');

        $time       = time();
        $map_column = array(
            array('sessionID', '', 'sessionID'),
            array('sessionData', '', 'sessionData'),
            array('expires', '', 'expires'),
        );
        $map_value  = array(
            array('myId', '', '', 'myId'),
            array(base64_encode('myData'), '', '', base64_encode('myData')),
            array($time, '', '', $time),
        );
        $this->query_builder->expects($this->exactly(4))
                 ->method('column')
                 ->will($this->returnValueMap($map_column));
        $this->query_builder->expects($this->exactly(4))
                 ->method('value')
                 ->will($this->returnValueMap($map_value));;
        $this->query_builder->expects($this->once())
                 ->method('where');

        $this->query_builder->expects($this->once())
                 ->method('get_select_query');
        $this->db->expects($this->exactly(2))
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->query_result->expects($this->once())
                 ->method('has_failed')
                 ->will($this->returnValue(FALSE));

        $this->query_builder->expects($this->once())
                 ->method('into')
                 ->with($this->equalTo('user_sessions'));
        $data = array(
            'sessionID'   => 'myId',
            'sessionData' => base64_encode('myData'),
            'expires'     => $time
        );
        $this->query_builder->expects($this->once())
                 ->method('set')
                 ->with($this->equalTo($data));
        $this->query_builder->expects($this->once())
                 ->method('get_replace_query');

        $this->db->expects($this->once())
                 ->method('commit');
        $this->db->expects($this->once())
                 ->method('end_transaction');

        $this->session_dao->write_session_data('myId', 'myData', $time);
    }

    /**
     * Test that Delete Session rollsback if there is no session.
     *
     * @covers     Lunr\Core\SessionDAO::delete_session
     */
    public function testDeleteSessionRollsBackIfQueryFails()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));
        $this->db->expects($this->once())
                 ->method('begin_transaction');

        $this->query_builder->expects($this->once())
                 ->method('lock_mode')
                 ->with($this->equalTo('FOR UPDATE'));

        $this->query_builder->expects($this->once())
                 ->method('table')
                 ->with($this->equalTo('user_sessions'));
        $this->query_builder->expects($this->once())
                 ->method('from');

        $this->query_builder->expects($this->once())
                 ->method('column')
                 ->with($this->equalTo('sessionID'));
        $this->query_builder->expects($this->once())
                 ->method('value')
                 ->with($this->equalTo('myId'));
        $this->query_builder->expects($this->once())
                 ->method('where');

        $this->query_builder->expects($this->once())
                 ->method('get_select_query');
        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->query_result->expects($this->once())
                 ->method('has_failed')
                 ->will($this->returnValue(TRUE));

        $this->db->expects($this->once())
                 ->method('rollback');
        $this->db->expects($this->once())
                 ->method('end_transaction');

        $this->session_dao->delete_session('myId');
    }

    /**
     * Test that Delete Session rollsback if there is no session.
     *
     * @covers     Lunr\Core\SessionDAO::delete_session
     */
    public function testDeleteSessionRollsBackIfQueryHasNoResults()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));
        $this->db->expects($this->once())
                 ->method('begin_transaction');

        $this->query_builder->expects($this->once())
                 ->method('lock_mode')
                 ->with($this->equalTo('FOR UPDATE'));

        $this->query_builder->expects($this->once())
                 ->method('table')
                 ->with($this->equalTo('user_sessions'));
        $this->query_builder->expects($this->once())
                 ->method('from');

        $this->query_builder->expects($this->once())
                 ->method('column')
                 ->with($this->equalTo('sessionID'));
        $this->query_builder->expects($this->once())
                 ->method('value')
                 ->with($this->equalTo('myId'));
        $this->query_builder->expects($this->once())
                 ->method('where');

        $this->query_builder->expects($this->once())
                 ->method('get_select_query');
        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->query_result->expects($this->once())
                 ->method('has_failed')
                 ->will($this->returnValue(FALSE));
        $this->query_result->expects($this->once())
                 ->method('number_of_rows')
                 ->will($this->returnValue(0));

        $this->db->expects($this->once())
                 ->method('rollback');
        $this->db->expects($this->once())
                 ->method('end_transaction');

        $this->session_dao->delete_session('myId');
    }

    /**
     * Test Delete Session.
     *
     * @covers     Lunr\Core\SessionDAO::delete_session
     */
    public function testDeleteSession()
    {
        $this->db->expects($this->exactly(2))
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));
        $this->db->expects($this->once())
                 ->method('begin_transaction');

        $this->query_builder->expects($this->once())
                 ->method('lock_mode')
                 ->with($this->equalTo('FOR UPDATE'));

        $this->query_builder->expects($this->exactly(2))
                 ->method('table')
                 ->with($this->equalTo('user_sessions'));
        $this->query_builder->expects($this->exactly(2))
                 ->method('from');

        $this->query_builder->expects($this->exactly(2))
                 ->method('column')
                 ->with($this->equalTo('sessionID'));
        $this->query_builder->expects($this->exactly(2))
                 ->method('value')
                 ->with($this->equalTo('myId'));
        $this->query_builder->expects($this->exactly(2))
                 ->method('where');

        $this->query_builder->expects($this->once())
                 ->method('get_select_query');
        $this->db->expects($this->exactly(2))
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->query_result->expects($this->once())
                 ->method('has_failed')
                 ->will($this->returnValue(FALSE));
        $this->query_result->expects($this->once())
                 ->method('number_of_rows')
                 ->will($this->returnValue(1));

        $this->query_builder->expects($this->once())
                 ->method('get_delete_query');

        $this->db->expects($this->once())
                 ->method('commit');
        $this->db->expects($this->once())
                 ->method('end_transaction');

        $this->session_dao->delete_session('myId');
    }

    /**
     * Test Session GC.
     *
     * @covers     Lunr\Core\SessionDAO::session_gc
     */
    public function testSessionGC()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));

        $this->query_builder->expects($this->once())
                 ->method('table')
                 ->with($this->equalTo('user_sessions'));
        $this->query_builder->expects($this->once())
                 ->method('from');

        runkit_function_redefine('time', '', 'return 10;');

        $this->query_builder->expects($this->once())
                 ->method('column')
                 ->with($this->equalTo('expires'));
        $this->query_builder->expects($this->once())
                 ->method('intvalue')
                 ->with($this->equalTo('10'));
        $this->query_builder->expects($this->once())
                 ->method('where');

        $this->query_builder->expects($this->once())
                 ->method('get_delete_query');
        $this->db->expects($this->once())
                 ->method('query');

        $this->session_dao->session_gc();
    }

}

?>
