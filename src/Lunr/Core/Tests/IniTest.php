<?php

/**
 * This file contains the IniTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Core\Tests;

use Lunr\Core\Ini;
use Lunr\Halo\LunrBaseTest;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Ini class.
 *
 * @covers Lunr\Core\Ini
 */
abstract class IniTest extends LunrBaseTest
{

    /**
     * Instance of the tested class.
     * @var Ini
     */
    protected Ini $class;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUpMain(): void
    {
        $this->class = new Ini();

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUpSection(): void
    {
        $this->class = new Ini('date');

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

    /**
     * Unit Test Data Provider for shorthand byte strings.
     *
     * @return array $values shorthand byte strings.
     */
    public function shorthandBytesProvider(): array
    {
        $values   = [];
        $values[] = [ '10', 10 ];
        $values[] = [ '10K', 10240 ];
        $values[] = [ '10M', 10485760 ];
        $values[] = [ '10G', 10737418240 ];

        return $values;
    }

}

?>
