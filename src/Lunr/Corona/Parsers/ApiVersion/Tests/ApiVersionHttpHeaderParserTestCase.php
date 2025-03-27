<?php

/**
 * This file contains the ApiVersionHttpHeaderParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ApiVersion\Tests;

use Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser;
use Lunr\Corona\Parsers\ApiVersion\Tests\Helpers\MockApiVersionEnum;
use Lunr\Halo\LunrBaseTestCase;

/**
 * This class contains test methods for the ApiVersionHttpHeaderParser class.
 *
 * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser
 */
abstract class ApiVersionHttpHeaderParserTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var ApiVersionHttpHeaderParser
     */
    protected ApiVersionHttpHeaderParser $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new ApiVersionHttpHeaderParser(MockApiVersionEnum::class);

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
