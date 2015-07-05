<?php

/**
 * This file contains the SessionDAOBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Sphere
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere\Tests;

use Lunr\Sphere\SessionDAO;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the SessionDAO class.
 *
 * @covers Lunr\Sphere\SessionDAO
 */
class SessionDAOBaseTest extends SessionDAOTest
{

    /**
     * Test that Read Session Data returns false if there is no session.
     *
     * @covers Lunr\Sphere\SessionDAO::read_session_data
     */
    public function testReadSessionDataReturnsFalseIfSessionNotExists()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $map_column = [
            ['sessionID', '', 'sessionID'],
            ['expires', '', 'expires'],
        ];

        $this->escaper->expects($this->once())
                      ->method('result_column')
                      ->will($this->returnValue('column1'));

        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('user_sessions'))
                      ->will($this->returnValue('user_sessions'));

        $this->escaper->expects($this->exactly(2))
                      ->method('column')
                      ->will($this->returnValueMap($map_column));

        $this->escaper->expects($this->once())
                      ->method('value')
                      ->with($this->equalTo('myId'));

        $this->escaper->expects($this->once())
                      ->method('intvalue');

        $this->query_builder->expects($this->once())
                            ->method('select')
                            ->with($this->equalTo('column1'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('from')
                            ->with($this->equalTo('user_sessions'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->exactly(2))
                            ->method('where')
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('get_select_query');

        $this->query_result->expects($this->once())
                           ->method('has_failed')
                           ->will($this->returnValue(TRUE));

        $this->assertFalse($this->class->read_session_data('myId'));

    }

    /**
     * Test that Read Session Data returns Session.
     *
     * @covers Lunr\Sphere\SessionDAO::read_session_data
     */
    public function testReadSessionDataReturnsSession()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $map_column = [
            ['sessionID', '', 'sessionID'],
            ['expires', '', 'expires'],
        ];

        $this->escaper->expects($this->once())
                      ->method('result_column')
                      ->with($this->equalTo('sessionData'))
                      ->will($this->returnValue('sessionData'));

        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('user_sessions'))
                      ->will($this->returnValue('user_sessions'));

        $this->escaper->expects($this->exactly(2))
                      ->method('column')
                      ->will($this->returnValueMap($map_column));

        $this->escaper->expects($this->once())
                      ->method('value')
                      ->with($this->equalTo('myId'));

        $this->query_builder->expects($this->once())
                            ->method('select')
                            ->with($this->equalTo('sessionData'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('from')
                            ->with($this->equalTo('user_sessions'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->exactly(2))
                            ->method('where')
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('get_select_query');

        $this->query_result->expects($this->once())
                           ->method('has_failed')
                           ->will($this->returnValue(FALSE));

        $this->query_result->expects($this->once())
                           ->method('number_of_rows')
                           ->will($this->returnValue(1));

        $this->query_result->expects($this->once())
                           ->method('result_cell')
                           ->will($this->returnValue(base64_encode('mySession')));

        $this->assertEquals($this->class->read_session_data('myId'), 'mySession');

    }

    /**
     * Test that Write Session Data rollsback if there is no session.
     *
     * @covers Lunr\Sphere\SessionDAO::write_session_data
     */
    public function testWriteSessionDataRollsBackIfNoSession()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));

        $this->db->expects($this->once())
                 ->method('begin_transaction');

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->db->expects($this->once())
                 ->method('rollback');

        $this->db->expects($this->once())
                 ->method('end_transaction');

        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('user_sessions'))
                      ->will($this->returnValue('user_sessions'));

        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('sessionID'))
                      ->will($this->returnValue('sessionID'));

        $this->escaper->expects($this->once())
                      ->method('value')
                      ->with($this->equalTo('myId'))
                      ->will($this->returnValue('myID'));

        $this->query_builder->expects($this->once())
                            ->method('from')
                            ->with($this->equalTo('user_sessions'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('where')
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('lock_mode')
                            ->with($this->equalTo('FOR UPDATE'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('get_select_query');

        $this->query_result->expects($this->once())
                           ->method('has_failed')
                           ->will($this->returnValue(TRUE));

        $this->class->write_session_data('myId', 'myData', time());
    }

    /**
     * Test that Write Session Data.
     *
     * @covers Lunr\Sphere\SessionDAO::write_session_data
     */
    public function testWriteSessionData()
    {
        $this->db->expects($this->exactly(2))
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));

        $this->db->expects($this->once())
                 ->method('begin_transaction');

        $this->db->expects($this->exactly(2))
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->db->expects($this->once())
                 ->method('commit');

        $this->db->expects($this->once())
                 ->method('end_transaction');

        $time = time();

        $map_column = [
            ['sessionID', '', 'sessionID'],
            ['sessionData', '', 'sessionData'],
            ['expires', '', 'expires'],
        ];

        $map_value = [
            ['myId', '', '', 'myId'],
            [base64_encode('myData'), '', '', base64_encode('myData')],
        ];

        $this->escaper->expects($this->exactly(2))
                      ->method('table')
                      ->with($this->equalTo('user_sessions'))
                      ->will($this->returnValue('user_sessions'));

        $this->escaper->expects($this->exactly(4))
                      ->method('column')
                      ->will($this->returnValueMap($map_column));

        $this->escaper->expects($this->exactly(3))
                      ->method('value')
                      ->will($this->returnValueMap($map_value));;

        $this->escaper->expects($this->once())
                      ->method('intvalue')
                      ->will($this->returnValue($time));;

        $this->query_builder->expects($this->once())
                            ->method('from')
                            ->with($this->equalTo('user_sessions'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('where')
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('lock_mode')
                            ->with($this->equalTo('FOR UPDATE'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('get_select_query');

        $data = [
            'sessionID'   => 'myId',
            'sessionData' => base64_encode('myData'),
            'expires'     => $time,
        ];

        $this->query_builder->expects($this->once())
                            ->method('into')
                            ->with($this->equalTo('user_sessions'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('set')
                            ->with($this->equalTo($data))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('get_replace_query');

        $this->query_result->expects($this->once())
                           ->method('has_failed')
                           ->will($this->returnValue(FALSE));

        $this->class->write_session_data('myId', 'myData', $time);
    }

    /**
     * Test that Delete Session rollsback if there is no session.
     *
     * @covers Lunr\Sphere\SessionDAO::delete_session
     */
    public function testDeleteSessionRollsBackIfQueryFails()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));

        $this->db->expects($this->once())
                 ->method('begin_transaction');

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->db->expects($this->once())
                 ->method('rollback');

        $this->db->expects($this->once())
                 ->method('end_transaction');

        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('user_sessions'))
                      ->will($this->returnValue('user_sessions'));

        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('sessionID'))
                      ->will($this->returnValue('sessionID'));

        $this->escaper->expects($this->once())
                      ->method('value')
                      ->with($this->equalTo('myId'))
                      ->will($this->returnValue('myId'));

        $this->query_builder->expects($this->once())
                            ->method('from')
                            ->with($this->equalTo('user_sessions'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('where')
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                 ->method('lock_mode')
                 ->with($this->equalTo('FOR UPDATE'))
                 ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('get_select_query');

        $this->query_result->expects($this->once())
                           ->method('number_of_rows')
                           ->will($this->returnValue(-1));

        $this->class->delete_session('myId');
    }

    /**
     * Test that Delete Session rollsback if there is no session.
     *
     * @covers Lunr\Sphere\SessionDAO::delete_session
     */
    public function testDeleteSessionRollsBackIfQueryHasNoResults()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));

        $this->db->expects($this->once())
                 ->method('begin_transaction');

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->db->expects($this->once())
                 ->method('rollback');

        $this->db->expects($this->once())
                 ->method('end_transaction');

        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('user_sessions'))
                      ->will($this->returnValue('user_sessions'));

        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('sessionID'))
                      ->will($this->returnValue('sessionID'));

        $this->escaper->expects($this->once())
                      ->method('value')
                      ->with($this->equalTo('myId'))
                      ->will($this->returnValue('myId'));

        $this->query_builder->expects($this->once())
                            ->method('from')
                            ->with($this->equalTo('user_sessions'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('where')
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('lock_mode')
                            ->with($this->equalTo('FOR UPDATE'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('get_select_query');

        $this->query_result->expects($this->once())
                           ->method('number_of_rows')
                           ->will($this->returnValue(0));

        $this->class->delete_session('myId');
    }

    /**
     * Test Delete Session.
     *
     * @covers Lunr\Sphere\SessionDAO::delete_session
     */
    public function testDeleteSession()
    {
        $this->db->expects($this->exactly(2))
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));

        $this->db->expects($this->once())
                 ->method('begin_transaction');

        $this->db->expects($this->exactly(2))
                 ->method('query')
                 ->will($this->returnValue($this->query_result));

        $this->db->expects($this->once())
                 ->method('commit');

        $this->db->expects($this->once())
                 ->method('end_transaction');

        $this->escaper->expects($this->exactly(2))
                      ->method('table')
                      ->with($this->equalTo('user_sessions'))
                      ->will($this->returnValue('user_sessions'));

        $this->escaper->expects($this->exactly(2))
                      ->method('column')
                      ->with($this->equalTo('sessionID'))
                      ->will($this->returnValue('sessionID'));

        $this->escaper->expects($this->exactly(2))
                      ->method('value')
                      ->with($this->equalTo('myId'));

        $this->query_builder->expects($this->exactly(2))
                            ->method('from')
                            ->with($this->equalTo('user_sessions'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->exactly(2))
                            ->method('where')
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('lock_mode')
                            ->with($this->equalTo('FOR UPDATE'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('get_select_query');

        $this->query_builder->expects($this->once())
                            ->method('get_delete_query');

        $this->query_result->expects($this->once())
                           ->method('number_of_rows')
                           ->will($this->returnValue(1));

        $this->class->delete_session('myId');
    }

    /**
     * Test Session GC.
     *
     * @covers Lunr\Sphere\SessionDAO::session_gc
     */
    public function testSessionGC()
    {
        $this->db->expects($this->once())
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($this->query_builder));

        $this->db->expects($this->once())
                 ->method('query');

        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('user_sessions'))
                      ->will($this->returnValue('user_sessions'));

        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('expires'))
                      ->will($this->returnValue('expires'));

        $this->escaper->expects($this->once())
                      ->method('intvalue')
                      ->will($this->returnValue('10'));

        $this->query_builder->expects($this->once())
                            ->method('from')
                            ->with($this->equalTo('user_sessions'))
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('where')
                            ->will($this->returnSelf());

        $this->query_builder->expects($this->once())
                            ->method('get_delete_query');

        $this->class->session_gc();
    }

}

?>
