<?php

/**
 * This file contains the DatabaseAccessObjectSelectQueryTestTrait.
 *
 * @package    Lunr\Halo
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests\Helpers;

use Lunr\Halo\FluidInterfaceMock;

/**
 * This trait contains helper methods to test general success and error cases of SELECT queries.
 */
trait DatabaseAccessObjectQueryTestTrait
{

    /**
     * Expect that a query returns successful results.
     *
     * @param mixed  $data   Result data
     * @param string $format Return result as 'array', 'row', 'column' or 'cell'
     *
     * @return void
     */
    public function expectResultOnSuccess($data, $format = 'array'): void
    {
        $mock = new FluidInterfaceMock();

        $this->db->expects($this->atLeast(1))
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($mock));

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('has_failed')
                     ->will($this->returnValue(FALSE));

        $count = $format === 'cell' ? 1 : count($data);

        $this->result->expects($this->once())
                     ->method('number_of_rows')
                     ->will($this->returnValue($count));

        $this->result->expects($this->once())
                     ->method('result_' . $format)
                     ->will($this->returnValue($data));
    }

    /**
     * Expect that a query returns no results.
     *
     * @param string $format Return result as 'array', 'row', 'column' or 'cell'
     *
     * @return void
     */
    public function expectNoResultsFound($format = 'array'): void
    {
        $mock = new FluidInterfaceMock();

        $this->db->expects($this->atLeast(1))
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($mock));

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('has_failed')
                     ->will($this->returnValue(FALSE));

        $this->result->expects($this->once())
                     ->method('number_of_rows')
                     ->will($this->returnValue(0));

        $this->result->expects($this->never())
                     ->method('result_' . $format);
    }

    /**
     * Expect that a query returns an error.
     *
     * @return void
     */
    protected function expectQueryError(): void
    {
        $mock = new FluidInterfaceMock();

        $this->db->expects($this->atLeast(1))
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($mock));

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('has_failed')
                     ->will($this->returnValue(TRUE));

        $this->expectException('Lunr\Gravity\Database\Exceptions\QueryException');
        $this->expectExceptionMessage('Database query error!');
    }

    /**
     * Expect that a query is successful.
     *
     * @return void
     */
    protected function expectQuerySuccess(): void
    {
        $mock = new FluidInterfaceMock();

        $this->db->expects($this->atLeast(1))
                 ->method('get_new_dml_query_builder_object')
                 ->will($this->returnValue($mock));

        $this->db->expects($this->once())
                 ->method('query')
                 ->will($this->returnValue($this->result));

        $this->result->expects($this->once())
                     ->method('has_failed')
                     ->will($this->returnValue(FALSE));
    }

}

?>
