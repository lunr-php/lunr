<?php

/**
 * This file contains the MySQLQueryEscaperTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLQueryEscaper;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the MySQLQueryEscaper class.
 *
 * @covers Lunr\Gravity\Database\MySQLQueryEscaper
 */
abstract class MySQLQueryEscaperTest extends LunrBaseTest
{

    /**
     * Mock instance of a class implementing the DatabaseStringEscaperInterface.
     * @var DatabaseStringEscaperInterface
     */
    protected $escaper;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->escaper = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseStringEscaperInterface')
                              ->getMock();

        $this->class = new MySQLQueryEscaper($this->escaper);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->escaper);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit Test Data Provider for invalid indices.
     *
     * @return array $indices Array of invalid indices
     */
    public function invalidIndicesProvider(): array
    {
        $indices   = [];
        $indices[] = [ NULL ];
        $indices[] = [ FALSE ];
        $indices[] = [ 'string' ];
        $indices[] = [ new \stdClass() ];
        $indices[] = [ [] ];

        return $indices;
    }

    /**
     * Unit Test Data Provider for valid Index Keywords.
     *
     * @return array $keywords Array of valid index keywords.
     */
    public function validIndexKeywordProvider(): array
    {
        $keywords   = [];
        $keywords[] = [ 'USE' ];
        $keywords[] = [ 'IGNORE' ];
        $keywords[] = [ 'FORCE' ];

        return $keywords;
    }

    /**
     * Unit Test Data Provider for valid Index use definitions.
     *
     * @return array $for Array of valid index use definitions.
     */
    public function validIndexForProvider(): array
    {
        $for   = [];
        $for[] = [ 'JOIN' ];
        $for[] = [ 'ORDER BY' ];
        $for[] = [ 'GROUP BY' ];
        $for[] = [ '' ];

        return $for;
    }

}

?>
