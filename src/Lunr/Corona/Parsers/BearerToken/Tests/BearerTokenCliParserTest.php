<?php

/**
 * This file contains the BearerTokenCliParserTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\BearerToken\Tests;

use Lunr\Corona\Parsers\BearerToken\BearerTokenCliParser;
use Lunr\Halo\LunrBaseTest;

/**
 * This class contains test methods for the BearerTokenCliParser class.
 *
 * @covers Lunr\Corona\Parsers\BearerToken\BearerTokenCliParser
 */
abstract class BearerTokenCliParserTest extends LunrBaseTest
{

    /**
     * Instance of the tested class.
     * @var BearerTokenCliParser
     */
    protected BearerTokenCliParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $token = '123456789';

        $ast = [
            'bearer-token' => [
                $token,
            ]
        ];

        $this->class = new BearerTokenCliParser($ast);

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
