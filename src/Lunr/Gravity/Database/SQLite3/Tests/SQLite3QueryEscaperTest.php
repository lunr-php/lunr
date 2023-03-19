<?php

/**
 * This file contains the SQLite3QueryEscaperTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the SQLite3QueryEscaper class.
 *
 * @covers Lunr\Gravity\Database\SQLite3QueryEscaper
 */
abstract class SQLite3QueryEscaperTest extends LunrBaseTest
{

    /**
     * Mock instance of the SQLite3Connection class.
     * @var SQLite3Connection
     */
    protected $db;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\SQLite3\SQLite3Connection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->class = new SQLite3QueryEscaper($this->db);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper');
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
        $keywords[] = [ 'INDEXED BY' ];

        return $keywords;
    }

}

?>
