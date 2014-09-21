<?php

/**
 * This file contains the NullDispatcherTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Tests
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Spawn\NullDispatcher;
use ReflectionClass;

/**
 * This class contains test set up and the data providers for the NullDispatcher class.
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Tests
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Spawn\NullDispatcher
 */
abstract class NullDispatcherTest extends LunrBaseTest
{

    /**
     * Instance of the LunrBaseTest class.
     * @var NullDispatcher
     */
    protected $class;

    /**
     * Reflection instance of the LunrBaseTest class.
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->reflection = new ReflectionClass('Lunr\Spawn\NullDispatcher');
        $this->class      = new NullDispatcher();
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->reflection);
        unset($this->class);
    }

}

?>
