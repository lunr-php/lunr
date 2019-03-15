<?php

/**
 * This file contains the DatabaseQueryEscaperTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseQueryEscaper;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use stdClass;

/**
 * This class contains the tests for the DatabaseQueryEscaper class.
 *
 * @covers Lunr\Gravity\Database\DatabaseQueryEscaper
 */
abstract class DatabaseQueryEscaperTest extends LunrBaseTest
{

    /**
     * Mock instance of the DatabaseConnection class.
     * @var DatabaseConnection
     */
    protected $db;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseConnection')
                         ->disableOriginalConstructor()
                         ->getMockForAbstractClass();

        $this->class = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseQueryEscaper')
                            ->setConstructorArgs([ $this->db ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseQueryEscaper');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->db);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit test data provider for column names.
     *
     * @return array $cols Array of column names and expected escaped values.
     */
    public function columnNameProvider(): array
    {
        $cols   = [];
        $cols[] = [ '*', '*' ];
        $cols[] = [ 'table.*', '`table`.*' ];
        $cols[] = [ 'col', '`col`' ];
        $cols[] = [ 'table.col', '`table`.`col`' ];
        $cols[] = [ 'db.table.col', '`db`.`table`.`col`' ];

        return $cols;
    }

    /**
     * Unit test data provider for table names.
     *
     * @return array $cols Array of table names and expected escaped values.
     */
    public function tableNameProvider(): array
    {
        $cols   = [];
        $cols[] = [ 'table', '`table`' ];
        $cols[] = [ 'db.table', '`db`.`table`' ];

        return $cols;
    }

    /**
     * Unit Test Data Provider for legal input values to be escaped as integer.
     *
     *  @return array $expecteds array of value to be escaped and their result
     */
    public function expectedIntegerProvider(): array
    {
        $expecteds   = [];
        $expecteds[] = [ '1', 1 ];
        $expecteds[] = [ '10', 10 ];
        $expecteds[] = [ '37', 37 ];

        return $expecteds;
    }

    /**
     * Unit Test Data Provider for legal input values to be escaped as integer.
     *
     *  @return array $expecteds array of value to be escaped and their result
     */
    public function expectedFloatProvider(): array
    {
        $expecteds   = [];
        $expecteds[] = [ '1.0', 1 ];
        $expecteds[] = [ '10.1', 10.1 ];

        return $expecteds;
    }

    /**
     * Unit Test Data Provider for illegalinput values to be escaped as integer.
     *
     *  @return array $illegals array of value to be escaped and their result
     */
    public function illegalIntegerProvider(): array
    {
        $illegals   = [];
        $illegals[] = [ 3.3, 3 ];

        $illegals[] = [ NULL, 0 ];

        $illegals[] = [ FALSE, 0 ];
        $illegals[] = [ TRUE, 1 ];

        $illegals[] = [ 'value', 0 ];
        $illegals[] = [ '1x10', 1 ];

        $illegals[] = [ [], 0 ];
        $illegals[] = [ [ 'a', 'b' ], 1 ];

        return $illegals;
    }

    /**
     * Unit Test Data Provider for illegalinput values to be escaped as float.
     *
     *  @return array $illegals array of value to be escaped and their result
     */
    public function illegalFloatProvider(): array
    {
        $illegals   = [];
        $illegals[] = [ '3.3.3', 3.3 ];

        $illegals[] = [ NULL, 0 ];

        $illegals[] = [ FALSE, 0 ];
        $illegals[] = [ TRUE, 1 ];

        $illegals[] = [ 'value', 0 ];

        $illegals[] = [ [], 0 ];
        $illegals[] = [ [ 'a', 'b' ], 1 ];

        return $illegals;
    }

    /**
     * Unit test data provider for invalid list_value() input values.
     *
     * @return array $values Array of invalid values.
     */
    public function invalidListValueInputProvider(): array
    {
        $values   = [];
        $values[] = [ 0 ];
        $values[] = [ 0.1 ];
        $values[] = [ 'string' ];
        $values[] = [ NULL ];
        $values[] = [ TRUE ];
        $values[] = [ new stdClass() ];

        return $values;
    }

}

?>
