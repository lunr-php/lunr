<?php

/**
 * This file contains the ModelTest class.
 *
 * @package   Lunr\Model
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2022, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
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
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->cache = $this->getMockBuilder('\Psr\Cache\CacheItemPoolInterface')
                            ->getMock();

        $this->item = $this->getMockBuilder('\Psr\Cache\CacheItemInterface')
                           ->getMock();

        $this->class = new Model($this->cache);

        $this->reflection = new ReflectionClass('Lunr\Corona\Model');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->cache);
        unset($this->item);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
