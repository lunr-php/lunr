<?php

/**
 * This file contains the APNSPayloadTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the APNSPayload class.
 *
 * @covers Lunr\Vortex\APNS\APNSPayload
 */
class APNSPayloadTest extends LunrBaseTest
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
            'alert' => 'apnsmessage',
            'badge' => 10,
            'sound' => 'bingbong.wav',
            'custom_data' => [
                'key1' => 'value1',
                'key2' => 'value2'
            ]
        ];

        $this->payload = json_encode($elements_array);

        $this->class = $this->getMockBuilder('Lunr\Vortex\APNS\APNSPayload')
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\APNSPayload');
    }

    /**
     * Unit test data provider for payload files.
     *
     * @return array $values Array of non-object values
     */
    public function payloadProvider()
    {
        $values   = [];
        $values[] = [ '/Vortex/apns_alert.json', [ 'alert' => 'apnsmessage' ] ];
        $values[] = [ '/Vortex/apns_custom_data.json', [ 'custom_data' => [ 'key1' => 'value1', 'key2' => 'value2' ] ] ];
        $values[] = [ '/Vortex/apns_badge.json', [ 'badge' => 10 ] ];
        $values[] = [ '/Vortex/apns.json', [
                        'alert' => 'apnsmessage',
                        'badge' => 10,
                        'sound' => 'bingbong.wav',
                        'custom_data' => [ 'key1' => 'value1', 'key2' => 'value2' ]
                    ] ];

        return $values;
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
