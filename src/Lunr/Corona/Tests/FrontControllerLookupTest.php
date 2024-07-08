<?php

/**
 * This file contains the FrontControllerLookupTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for getting controllers from the FrontController class.
 *
 * @covers Lunr\Corona\FrontController
 */
class FrontControllerLookupTest extends FrontControllerTest
{

    /**
     * Test that lookup() returns empty string with no identifier passed.
     *
     * @covers Lunr\Corona\FrontController::lookup
     */
    public function testVoidLookup(): void
    {
        $this->set_reflection_property_value('paths', []);

        $value = $this->class->lookup();

        $this->assertEquals('', $value);
    }

    /**
     * Test lookup() with no paths set.
     *
     * @covers Lunr\Corona\FrontController::lookup
     */
    public function testLookupWithoutPath(): void
    {
        $this->set_reflection_property_value('paths', []);

        $value = $this->class->lookup('test');

        $this->assertEquals('', $value);
    }

    /**
     * Test that lookup() finds controllers when looking in a single path.
     *
     * @covers Lunr\Corona\FrontController::lookup
     */
    public function testLookupWithSinglePath(): void
    {
        $this->set_reflection_property_value('paths', [ 'test' => TEST_STATICS . '/Corona/' ]);

        $fqcn = 'Project\\Package1\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->lookup('test');

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that lookup() finds controllers when looking in multiple paths.
     *
     * @covers Lunr\Corona\FrontController::lookup
     */
    public function testLookupWithMultiplePaths(): void
    {
        $paths = [
            'live' => TEST_STATICS . '/../../src/Lunr/Corona/',
            'acc'  => TEST_STATICS . '/../../LICENSES/',
            'test' => TEST_STATICS . '/Corona/',
        ];

        $this->set_reflection_property_value('paths', $paths);

        $fqcn = 'Project\\Package1\\FunctionController';

        $this->request->expects($this->exactly(4))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->lookup('live', 'test');

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test lookup() with a nonexisting path.
     *
     * @covers Lunr\Corona\FrontController::lookup
     */
    public function testLookupWithNonExistingPath(): void
    {
        $paths = [
            'live' => TEST_STATICS . '/../../src/Lunr/Corona/',
            'acc'  => TEST_STATICS . '/../../LICENSES/',
            'test' => TEST_STATICS . '/Corona/',
        ];

        $this->set_reflection_property_value('paths', $paths);

        $value = $this->class->lookup('prod');

        $this->assertEquals('', $value);
    }

    /**
     * Test that lookup() finds controllers when looking in all paths.
     *
     * @covers Lunr\Corona\FrontController::lookup
     */
    public function testLookupWithAllPaths(): void
    {
        $paths = [
            'live' => TEST_STATICS . '/../../src/Lunr/Corona/',
            'acc'  => TEST_STATICS . '/../../LICENSES/',
            'test' => TEST_STATICS . '/Corona/',
        ];

        $this->set_reflection_property_value('paths', $paths);

        $fqcn = 'Project\\Package1\\FunctionController';

        $this->request->expects($this->exactly(6))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->lookup();

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that lookup() returns an empty string when no controller is found.
     *
     * @covers Lunr\Corona\FrontController::lookup
     */
    public function testLookupFails(): void
    {
        $this->set_reflection_property_value('paths', [ 'test' => TEST_STATICS . '/Corona/' ]);

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('bar');

        $value = $this->class->lookup('test');

        $this->assertEquals('', $value);
    }

}

?>
