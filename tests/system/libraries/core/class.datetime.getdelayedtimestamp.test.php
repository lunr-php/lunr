<?php

namespace Lunr\Libraries\Core;
use Lunr\Libraries\Core\DateTime;

/**
 * This tests Lunr's DateTime class
 * @covers Lunr\Libraries\Core\DateTime
 */
class DateTimeGetDelayedTimestampTest extends DateTimeTest
{

    /**
     * Test get_delayed_timestamp() with the current timestamp as base.
     *
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithCurrentTimestampAsBase()
    {
        $this->assertEquals(strtotime("+1 day"), $this->datetime->get_delayed_timestamp("+1 day"));
    }

    /**
     * Test get_delayed_timestamp() with a custom timestamp as base.
     *
     * @dataProvider timestampProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithCustomTimestampAsBase($base)
    {
        $this->assertEquals(strtotime("+1 day", $base), $this->datetime->get_delayed_timestamp("+1 day", $base));
    }

    /**
     * Test get_delayed_timestamp() with a custom but invalid timestamp as base.
     *
     * @dataProvider invalidTimestampProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithCustomInvalidTimestampAsBase($base)
    {
        $this->assertFalse($this->datetime->get_delayed_timestamp("+1 day", $base));
    }

    /**
     * Test get_delayed_timestamp() with a valid delay and current timestamp as base.
     *
     * @dataProvider validDelayProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithValidDelay($delay)
    {
        $this->assertEquals(strtotime($delay), $this->datetime->get_delayed_timestamp($delay));
    }

    /**
     * Test get_delayed_timestamp() with an invalid delay and current timestamp as base.
     *
     * @dataProvider invalidDelayProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithInvalidDelay($delay)
    {
        $this->assertFalse($this->datetime->get_delayed_timestamp($delay));
    }

}

?>
