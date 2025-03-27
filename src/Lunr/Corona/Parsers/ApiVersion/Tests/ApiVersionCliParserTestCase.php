<?php

/**
 * This file contains the ApiVersionCliParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ApiVersion\Tests;

use Lunr\Corona\Parsers\ApiVersion\ApiVersionCliParser;
use Lunr\Corona\Parsers\ApiVersion\Tests\Helpers\MockApiVersionEnum;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the ApiVersionCliParser class.
 *
 * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionCliParser
 */
abstract class ApiVersionCliParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var ApiVersionCliParser
     */
    protected ApiVersionCliParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $version = '1';

        $ast = [
            'api-version' => [
                $version,
            ]
        ];

        $this->class = new ApiVersionCliParser(MockApiVersionEnum::class, $ast);

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
