<?php

/**
 * This file contains the CacheHandlerTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Cache
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Cache\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the Cache class.
 *
 * @covers Lunr\Cache\Cache
 */
abstract class CacheHandlerTest extends LunrBaseTest
{

    /**
     * Shared instance of the cache Pool class.
     * @var Pool
     */
    protected $cache_pool;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->cache_pool = $this->getMockBuilder('\Psr\Cache\CacheItemPoolInterface')->getMock();

        $this->class = $this->getMockBuilder('Lunr\Cache\Cache')
                            ->setConstructorArgs([ $this->cache_pool ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Cache\Cache');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->cache_pool);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
