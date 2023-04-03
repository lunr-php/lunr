<?php

/**
 * This file contains the DatabaseQueryEscaperNullEscapeTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
     * @return array $escapers Valid value escapers
     */
    public function validValueEscaperProvider(): array
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
            '(A, B, C)',
        ];

        return $escapers;
    }

    /**
     * Unit test data provider for invalid value escapers.
     *
     * @return array $escapers Invalid value escapers
     */
    public function invalidValueEscaperProvider(): array
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
     * @param string $name      Escaper function name
     * @param array  $arguments Arguments for the escaper function
     * @param mixed  $expected  Expected escaped result
     *
     * @dataProvider validValueEscaperProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::__call
     */
    public function testEscapeWithValidValueEscapers($name, $arguments, $expected): void
    {
        $method = 'null_or_' . $name;

        $result = $this->class->{$method}($arguments);

        $this->assertSame($expected, $result);
    }

    /**
     * Test escaping unsupported values through null-safe calling.
     *
     * @param string $name      Escaper function name
     * @param array  $arguments Arguments for the escaper function
     *
     * @dataProvider invalidValueEscaperProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::__call
     */
    public function testEscapeWithInvalidValueEscapers($name, $arguments): void
    {
        $method = 'null_or_' . $name;

        $result = $this->class->{$method}(...$arguments);

        $this->assertNull($result);
    }

    /**
     * Test escaping null values.
     *
     * @param string $name Escaper function name
     *
     * @dataProvider validValueEscaperProvider
     * @covers       Lunr\Gravity\Database\DatabaseQueryEscaper::__call
     */
    public function testEscapeNull($name): void
    {
        $method = 'null_or_' . $name;

        $result = $this->class->{$method}(NULL);

        $this->assertNull($result);
    }

}

?>
