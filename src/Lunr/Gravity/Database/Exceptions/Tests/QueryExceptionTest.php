<?php

/**
 * This file contains the QueryExceptionTest class.
 *
 * @package Lunr\Gravity\Database\Exceptions
 * @author  Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Gravity\Database\Exceptions\Tests;

use Lunr\Gravity\Database\Exceptions\QueryException;
use Lunr\Halo\LunrBaseTest;
use Exception;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the QueryException class.
 */
abstract class QueryExceptionTest extends LunrBaseTest
{

    /**
     * Mock instance of a query result.
     * @var \Lunr\Gravity\Database\DatabaseQueryResultInterface
     */
    protected $result;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->result = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseQueryResultInterface')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->result->expects($this->once())
                     ->method('query')
                     ->willReturn('SQL query');

        $this->result->expects($this->once())
                     ->method('error_number')
                     ->willReturn(1024);

        $this->result->expects($this->once())
                     ->method('error_message')
                     ->willReturn("There's an error in your query.");

        $this->class      = new QueryException($this->result, 'Exception Message');
        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\Exceptions\QueryException');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->result);
        unset($this->reflection);
        unset($this->class);
    }

}

?>
