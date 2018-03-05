<?php

/**
 * This file contains the FCMPayloadTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the FCMPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMPayload
 */
class FCMPayloadTest extends LunrBaseTest
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
            'registration_ids' => [ 'one', 'two', 'three' ],
            'collapse_key'     => 'test',
            'data'             => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            'time_to_live'     => 10,
        ];

        $this->payload = json_encode($elements_array);

        $this->class = $this->getMockBuilder('Lunr\Vortex\FCM\FCMPayload')
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Vortex\FCM\FCMPayload');
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
