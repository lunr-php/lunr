<?php

/**
 * This file contains the WebRequestParserTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use http\Header;
use Lunr\Core\Configuration;
use Lunr\Corona\WebRequestParser;
use Lunr\Halo\LunrBaseTest;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WebRequestParser class.
 *
 * @covers     Lunr\Corona\WebRequestParser
 */
abstract class WebRequestParserTest extends LunrBaseTest
{

    /**
     * Mock of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of the Header class
     * @var Header
     */
    protected $header;

    /**
     * Instance of the tested class.
     * @var WebRequestParser
     */
    protected WebRequestParser $class;

    /**
     * Shared TestCase Constructor code.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();
        $this->header        = $this->getMockBuilder('http\Header')->getMock();

        $this->class = new WebRequestParser($this->configuration, $this->header);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->configuration);
        unset($this->header);

        parent::tearDown();
    }

    /**
     * Unit Test Data Provider for invalid super global values.
     *
     * @return array $cookie Set of invalid super global values
     */
    public function invalidSuperglobalValueProvider(): array
    {
        $values   = [];
        $values[] = [ [], FALSE ];
        $values[] = [ 0, FALSE ];
        $values[] = [ 'String', FALSE ];
        $values[] = [ TRUE, FALSE ];
        $values[] = [ NULL, FALSE ];
        $values[] = [ [], TRUE ];
        $values[] = [ 0, TRUE ];
        $values[] = [ 'String', TRUE ];
        $values[] = [ TRUE, TRUE ];
        $values[] = [ NULL, TRUE ];

        return $values;
    }

    /**
     * Unit Test Data Provider for Accept header content type(s).
     *
     * @return array $value Array of content type(s)
     */
    public function contentTypeProvider(): array
    {
        $value   = [];
        $value[] = [ 'text/html' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header language(s).
     *
     * @return array $value Array of language(s)
     */
    public function acceptLanguageProvider(): array
    {
        $value   = [];
        $value[] = [ 'en-US' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header charset(s).
     *
     * @return array $value Array of charset(s)
     */
    public function acceptCharsetProvider(): array
    {
        $value   = [];
        $value[] = [ 'utf-8' ];

        return $value;
    }

}

?>
