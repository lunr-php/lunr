<?php

/**
 * This file contains the TracingInfoParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\TracingInfo\Tests;

use Lunr\Corona\Parsers\TracingInfo\TracingInfoParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the TracingInfoParser class.
 *
 * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser
 */
abstract class TracingInfoParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var TracingInfoParser
     */
    protected TracingInfoParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new TracingInfoParser();

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);

        parent::tearDown();
    }

}

?>
