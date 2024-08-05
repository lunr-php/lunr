<?php

/**
 * This file contains the L10nProviderTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\L10n\L10nProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Psr\Log\LoggerInterface;

/**
 * This class contains test methods for the abstract L10nProvider class.
 *
 * @covers Lunr\L10n\L10nProvider
 */
abstract class L10nProviderTest extends LunrBaseTest
{

    /**
     * Mock Object for a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Instance of the tested class.
     * @var L10nProvider&MockObject&Stub
     */
    protected L10nProvider&MockObject&Stub $class;

    /**
     * The language used for testing.
     * @var string
     */
    protected const LANGUAGE = 'de_DE';

    /**
     * The domain used for testing.
     * @var string
     */
    protected const DOMAIN = 'Lunr';

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->class = $this->getMockBuilder('Lunr\L10n\L10nProvider')
                            ->setConstructorArgs([ self::LANGUAGE, self::DOMAIN, $this->logger, TEST_STATICS . '/l10n/' ])
                            ->getMockForAbstractClass();

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->logger);

        parent::tearDown();
    }

}

?>
