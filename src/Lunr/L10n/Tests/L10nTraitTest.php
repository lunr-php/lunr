<?php

/**
 * This file contains the L10nTraitTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\L10nTrait;
use Lunr\Halo\LunrBaseTest;
use Psr\Log\LoggerInterface;
use ReflectionClass;

/**
 * This class contains test methods for the L10n class.
 *
 * @covers Lunr\L10n\L10nTrait
 */
class L10nTraitTest extends LunrBaseTest
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
     * Test case constructor.
     */
    public function setUp(): void
    {
        $this->class      = $this->getObjectForTrait('Lunr\L10n\L10nTrait');
        $this->reflection = new ReflectionClass($this->class);
        $this->logger     = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->set_reflection_property_value('logger', $this->logger);
    }

    /**
     * Test case destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->logger);
    }

}

?>
