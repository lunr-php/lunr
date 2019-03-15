<?php

/**
 * This file contains the CompactJsonViewBaseTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for the CompactJsonView class.
 *
 * @covers     Lunr\Corona\CompactJsonView
 */
class CompactJsonViewBaseTest extends CompactJsonViewTest
{

    /**
     * Test that the Request class is passed correctly.
     */
    public function testRequestIsPassedCorrectly(): void
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the Response class is passed correctly.
     */
    public function testResponseIsPassedCorrectly(): void
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that the Configuration class is passed correctly.
     */
    public function testConfigurationIsPassedCorrectly(): void
    {
        $this->assertPropertySame('configuration', $this->configuration);
    }

    /**
     * Test that prepare_data() does not modify the data.
     *
     * @param array $data     Data values
     * @param array $expected Modified data values
     *
     * @dataProvider dataProvider
     * @covers       Lunr\Corona\CompactJsonView::prepare_data
     */
    public function testPrepareDataReturnsModifiedData($data, $expected): void
    {
        $method = $this->get_accessible_reflection_method('prepare_data');

        $this->assertSame($expected, $method->invokeArgs($this->class, [ $data ]));
    }

}

?>
