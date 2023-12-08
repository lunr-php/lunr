<?php

/**
 * This file contains the L10nTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\L10n;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the L10n class.
 *
 * @covers Lunr\L10n\L10n
 */
abstract class L10nTest extends LunrBaseTest
{

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Array of supported languages.
     * @var array
     */
    protected $languages;

    /**
     * Instance of the tested class.
     * @var L10n
     */
    protected L10n $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->class = new L10n($this->logger, TEST_STATICS . '/l10n/');

        $this->languages = [ 'de_DE', 'en_US', 'nl_NL' ];

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->logger);
        unset($this->class);
        unset($this->languages);

        parent::tearDown();
    }

    /**
     * Unit Test Data Provider for supported languages.
     *
     * @return array $languages Array of supported languages
     */
    public function supportedLanguagesProvider(): array
    {
        $languages   = [];
        $languages[] = [ 'en', 'en_US' ];
        $languages[] = [ 'nl', 'nl_NL' ];

        return $languages;
    }

    /**
     * Unit Test Data Provider for unsupported languages.
     *
     * @return array $languages Array of unsupported languages
     */
    public function unsupportedLanguagesProvider(): array
    {
        $languages   = [];
        $languages[] = [ 'fr', 'fr_FR' ];

        return $languages;
    }

}

?>
