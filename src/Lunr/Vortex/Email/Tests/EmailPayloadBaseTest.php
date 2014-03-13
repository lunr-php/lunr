<?php

/**
 * This file contains the EmailPayloadBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

/**
 * This class contains the Base tests of the GCMPayload class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Vortex\Email\EmailPayload
 */
class EmailPayloadBaseTest extends EmailPayloadTest
{

    /**
     * Test elements is initialized as an empty array.
     */
    public function testElementsIsInitializedAsEmptyArray()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('elements'));
    }

}

?>
