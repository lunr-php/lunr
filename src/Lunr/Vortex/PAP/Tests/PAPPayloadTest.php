<?php

/**
 * This file contains the PAPPayloadTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the PAPPayload class.
 *
 * @covers Lunr\Vortex\PAP\PAPPayload
 */
abstract class PAPPayloadTest extends LunrBaseTest
{

    /**
     * Sample payload json
     * @var string
     */
    protected $payload;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $elements_array = [
            'message' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
        ];

        $this->payload = json_encode($elements_array);

        $this->class = $this->getMockBuilder('Lunr\Vortex\PAP\PAPPayload')
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Vortex\PAP\PAPPayload');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->payload);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
