<?php

/**
 * This file contains the SQLite3ConnectionQueryTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Ruben de Groot <r.degroot@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3Connection;

/**
 * This class contains query related unit tests for SQLite3Connection.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection
 */
class SQLite3ConnectionQueryTest extends SQLite3ConnectionTest
{
	/**
     * Test that query() returns a QueryResult that indicates a failed query when not connected.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::query
     */
    public function testQueryReturnsFailedQueryResultWhenNotConnected()
    {
        $query = $this->class->query('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3QueryResult', $query);
        $this->assertTrue($query->has_failed());
    }

    /**
     * Test that query() returns a QueryResult when connected.
     *
     * @covers   Lunr\Gravity\Database\SQLite3\SQLite3Connection::query
     */
    public function testQueryReturnsQueryResultWhenConnected()
    {
		$this->set_reflection_property_value('connected', TRUE);

        $this->sqlite3->expects($this->once())
                      ->method('query')
                      ->will($this->returnValue(TRUE));

        $query = $this->class->query('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3QueryResult', $query);
        $this->assertFalse($query->has_failed());
    }
}

?>
