<?php

/**
 * This file contains the DatabaseQueryEscaperNullEscapeTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseQueryEscaper;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the DatabaseQueryEscaper class.
 *
 * @covers Lunr\Gravity\Database\DatabaseQueryEscaper
 */
class DatabaseQueryEscaperNullEscapeTest extends DatabaseQueryEscaperTest
{

    /**
     * Unit test data provider for valid value escapers.
     *
     * @return Array $escapers Valid value escapers
     */
    public function validValueEscaperProvider()
    {
        $escapers   = [];
        $escapers[] = [
            'intvalue',
            '100',
            100,
        ];
        $escapers[] = [
            'floatvalue',
            '100.0',
            100.0,
        ];
        $escapers[] = [
            'query_value',
            'SELECT * FROM table',
            '(SELECT * FROM table)',
        ];
        $escapers[] = [
            'list_value',
            [ 'A', 'B', 'C' ],
            '(A,B,C)',
        ];

        return $escapers;
    }

    /**
     * Unit test data provider for invalid value escapers.
     *
     * @return Array $escapers Invalid value escapers
     */
    public function invalidValueEscaperProvider()
    {
        $escapers   = [];
        $escapers[] = [
            'table',
            [ 'foo' ],
        ];
        $escapers[] = [
            'collate',
            [ 'value', 'collate' ],
        ];

        return $escapers;
    }

    /**
     * Test escaping values through null-safe calling.
     *
     * @param String $name      Escaper function name
     * @param Array  $arguments Arguments for the escaper function
     * @param mixed  $expected  Expected escaped result
     *
     * @dataProvider validValueEscaperProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::__call
     */
    public function testEscapeWithValidValueEscapers($name, $arguments, $expected)
    {
        $method = 'null_or_' . $name;

        $result = $this->class->{$method}($arguments);

        $this->assertSame($expected, $result);
    }

    /**
     * Test escaping unsupported values through null-safe calling.
     *
     * @param String $name      Escaper function name
     * @param Array  $arguments Arguments for the escaper function
     *
     * @dataProvider invalidValueEscaperProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::__call
     */
    public function testEscapeWithInvalidValueEscapers($name, $arguments)
    {
        $method = 'null_or_' . $name;

        $result = $this->class->{$method}(...$arguments);

        $this->assertNull($result);
    }

    /**
     * Test escaping null values.
     *
     * @param String $name Escaper function name
     *
     * @dataProvider validValueEscaperProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::__call
     */
    public function testEscapeNull($name)
    {
        $method = 'null_or_' . $name;

        $result = $this->class->{$method}(NULL);

        $this->assertNull($result);
    }

}

?>
