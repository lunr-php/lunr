<?php

/**
 * This file contains the ModelTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Corona\Model;
use ReflectionClass;

/**
 * This class contains test methods for the Model class.
 *
 * @covers Lunr\Corona\Model
 */
abstract class ModelTest extends LunrBaseTest
{

    /**
     * Shared instance of the cache pool class.
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    protected $cache;

    /**
     * Shared instance of the cache item class.
     * @var \Psr\Cache\CacheItemInterface
     */
    protected $item;

    /**
     * Instance of the tested class.
     * @var Model
     */
    protected Model $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->cache = $this->getMockBuilder('\Psr\Cache\CacheItemPoolInterface')
                            ->getMock();

        $this->item = $this->getMockBuilder('\Psr\Cache\CacheItemInterface')
                           ->getMock();

        $this->class = new Model($this->cache);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->cache);
        unset($this->item);
        unset($this->class);

        parent::tearDown();
    }

}

?>
