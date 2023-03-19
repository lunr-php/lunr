<?php

/**
 * This file contains the GetoptCliParserTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

use Lunr\Shadow\GetoptCliParser;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the GetoptCliParser class.
 *
 * @covers Lunr\Shadow\GetoptCliParser
 */
abstract class GetoptCliParserTest extends LunrBaseTest
{

    /**
     * Test case constructor.
     */
    public function setUp(): void
    {
        $this->class      = new GetoptCliParser('ab:c::', [ 'first', 'second:', 'third::' ]);
        $this->reflection = new ReflectionClass('Lunr\Shadow\GetoptCliParser');
    }

    /**
     * Test case destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit test data provider for command line values.
     *
     * @return array $values Array of command line argument values.
     */
    public function valueProvider()
    {
        $values   = [];
        $values[] = [ 'string' ];
        $values[] = [ 1 ];
        $values[] = [ 1.1 ];
        $values[] = [ TRUE ];
        $values[] = [ NULL ];

        return $values;
    }

}

?>
