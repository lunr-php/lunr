<?php

/**
 * This file contains the JPushPayloadTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\JPush\JPushMessagePayload;
use Lunr\Vortex\JPush\JPushNotificationPayload;
use Lunr\Vortex\JPush\JPushPayload;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the JPushPayload class.
 *
 * @covers Lunr\Vortex\JPush\JPushPayload
 */
class JPushMessagePayloadTest extends LunrBaseTest
{

    /**
     * Sample payload json
     * @var string
     */
    protected $payload;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
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

        $this->class = new JPushMessagePayload();

        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushMessagePayload');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->payload);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
