<?php

/**
 * This file contains the NullDispatcherTest class.
 *
 * @package    Lunr\Spawn
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Spawn\NullDispatcher;
use ReflectionClass;

/**
 * This class contains test set up and the data providers for the NullDispatcher class.
 *
 * @covers Lunr\Spawn\NullDispatcher
 */
abstract class NullDispatcherTest extends LunrBaseTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->reflection = new ReflectionClass('Lunr\Spawn\NullDispatcher');
        $this->class      = new NullDispatcher();
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->reflection);
        unset($this->class);
    }

}

?>
