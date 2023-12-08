<?php

/**
 * This file contains the AbstractL10nTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\AbstractL10n;
use Lunr\Halo\LunrBaseTest;
use Psr\Log\LoggerInterface;
use ReflectionClass;

/**
 * This class contains test methods for the L10n class.
 *
 * @covers Lunr\L10n\AbstractL10n
 */
class AbstractL10nTest extends LunrBaseTest
{

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * The language used for testing.
     * @var string
     */
    protected const LANGUAGE = 'de_DE';

    /**
     * Instance of the tested class.
     * @var object
     */
    protected object $class;

    /**
     * Test case constructor.
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->class = $this->getMockBuilder('Lunr\L10n\AbstractL10n')
                            ->setConstructorArgs([ $this->logger ])
                            ->getMockForAbstractClass();

        parent::baseSetUp($this->class);

        $this->set_reflection_property_value('logger', $this->logger);
    }

    /**
     * Test case destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->logger);

        parent::tearDown();
    }

}

?>
