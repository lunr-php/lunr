<?php

/**
 * This file contains the SapiParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Sapi\Tests;

use Lunr\Corona\Parsers\Sapi\SapiParser;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the SapiParser class.
 *
 * @covers Lunr\Corona\Parsers\Sapi\SapiParser
 */
abstract class SapiParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var SapiParser
     */
    protected SapiParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new SapiParser();

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
