<?php

/**
 * This file contains the VerificationResultTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Flare\Tests;

use Lunr\Flare\Verification;

/**
 * This class contains the tests for result checking methods.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Flare\Verification
 */
class VerificationResultTest extends VerificationTest
{

    /**
     * Test that is_overchecked() returns FALSE when there are no superfluous elements being checked.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testSuperfluousIsEmptyByDefault
     * @covers  Lunr\Flare\Verification::is_overchecked
     */
    public function testIsOvercheckedReturnsFalseWhenSuperfluousIsEmpty()
    {
        $method = $this->get_accessible_reflection_method('is_overchecked');

        $this->assertFalse($method->invokeArgs($this->class, array('')));
    }

    /**
     * Test that is_overchecked() returns TRUE when there are superfluous elements being checked.
     *
     * @covers Lunr\Flare\Verification::is_overchecked
     */
    public function testIsOvercheckedReturnsTrueWhenSuperfluousIsNotEmpty()
    {
        $method = $this->get_accessible_reflection_method('is_overchecked');

        $this->set_reflection_property_value('superfluous', array('test1', 'test2'));

        $this->logger->expects($this->exactly(2))
                     ->method('error');

        $this->assertTrue($method->invokeArgs($this->class, array('')));
    }

    /**
     * Test that is_fully_checked() returns TRUE when all data keys have been checked.
     *
     * @param array $data   dataset to check
     * @param array $result check results
     *
     * @dataProvider isFullyCheckedProvider
     * @covers       Lunr\Flare\Verification::is_fully_checked
     */
    public function testIsFullyCheckedReturnsTrueWhenAllDataKeysHaveBeenChecked($data, $result)
    {
        $this->set_reflection_property_value('data', $data);

        $results = $this->set_reflection_property_value('result', $result);

        $method = $this->get_accessible_reflection_method('is_fully_checked');

        $this->assertTrue($method->invokeArgs($this->class, array('')));
    }

    /**
     * Test that is_fully_checked() returns FALSE when not all data keys have been checked.
     *
     * @param array $data   dataset to check
     * @param array $result check results
     *
     * @dataProvider isNotFullyCheckedProvider
     * @covers       Lunr\Flare\Verification::is_fully_checked
     */
    public function testIsFullyCheckedReturnsFalseWhenNotAllDataKeysHaveBeenChecked($data, $result)
    {
        $checked_data = $this->set_reflection_property_value('data', $data);

        $results = $this->set_reflection_property_value('result', $result);

        $method = $this->get_accessible_reflection_method('is_fully_checked');

        $this->logger->expects($this->exactly(sizeof($data) - sizeof($result)))
                     ->method('error');

        $this->assertFalse($method->invokeArgs($this->class, array('')));
    }

    /**
     * Test that is_valid() returns FALSE if there is no identifier set.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testIdentifierIsEmptyStringByDefault
     * @covers  Lunr\Flare\Verification::is_valid
     */
    public function testIsValidReturnsFalseIfIdentifierIsEmpty()
    {
        $this->logger->expects($this->once())
                     ->method('error');

        $this->assertFalse($this->class->is_valid());
    }

    /**
     * Test that is_valid() returns FALSE when check_superfluous is TRUE and is_overchecked Returnes TRUE.
     *
     * @depends testIsOvercheckedReturnsTrueWhenSuperfluousIsNotEmpty
     * @covers  Lunr\Flare\Verification::is_valid
     */
    public function testIsValidReturnsFalseIfCheckSuperfluousEnabledAndIsOvercheckedTrue()
    {
        $this->logger->expects($this->exactly(2))
                     ->method('error');

        $identifier = $this->set_reflection_property_value('identifier', 'testrun');

        $this->set_reflection_property_value('check_superfluous', TRUE);

        $this->set_reflection_property_value('superfluous', array('test1', 'test2'));

        $this->assertFalse($this->class->is_valid());
    }

    /**
     * Test that is_valid() returns FALSE when check_remaining is TRUE and is_fully_checked Returnes FALSE.
     *
     * @depends testIsFullyCheckedReturnsFalseWhenNotAllDataKeysHaveBeenChecked
     * @covers  Lunr\Flare\Verification::is_valid
     */
    public function testIsValidReturnsFalseIfCheckRemainingEnabledAndIsFullyCheckedFalse()
    {
        $this->logger->expects($this->once())
                     ->method('error');

        $this->set_reflection_property_value('identifier', 'testrun');

        $this->set_reflection_property_value('data', array('test' => 'value'));

        $this->set_reflection_property_value('result', array());

        $this->assertFalse($this->class->is_valid());
    }

    /**
     * Test that is_valid() returns FALSE if a check failed.
     *
     * @covers Lunr\Flare\Verification::is_valid
     */
    public function testIsValidReturnsFalseIfACheckFailed()
    {
        $this->set_reflection_property_value('identifier', 'testrun');

        $this->set_reflection_property_value('check_remaining', FALSE);

        $this->set_reflection_property_value('data', array('test1' => 'value1', 'test2' => 'value2'));

        $value = array('is_length_5' => FALSE);
        $this->set_reflection_property_value('result', array('test1' => $value, 'test2' => $value));

        $this->logger->expects($this->exactly(2))
                     ->method('error');

        $this->assertFalse($this->class->is_valid());
    }

    /**
     * Test that is_valid() returns TRUE if no check failed.
     *
     * @covers Lunr\Flare\Verification::is_valid
     */
    public function testIsValidReturnsTrueIfNoCheckFailed()
    {
        $this->set_reflection_property_value('identifier', 'testrun');

        $this->set_reflection_property_value('check_remaining', FALSE);

        $this->set_reflection_property_value('data', array('test1' => 'value1', 'test2' => 'value2'));

        $value = array('is_length_6' => TRUE);
        $this->set_reflection_property_value('result', array('test1' => TRUE, 'test2' => $value));

        $this->assertTrue($this->class->is_valid());
    }

    /**
     * Test that is_valid() returns TRUE if no check failed and is_overchecked returns FALSE.
     *
     * @depends testIsOvercheckedReturnsFalseWhenSuperfluousIsEmpty
     * @covers  Lunr\Flare\Verification::is_valid
     */
    public function testIsValidReturnsTrueIfNoCheckFailedAndIsOvercheckedIsFalse()
    {
        $this->set_reflection_property_value('identifier', 'testrun');

        $this->set_reflection_property_value('check_superfluous', TRUE);

        $this->set_reflection_property_value('check_remaining', FALSE);

        $this->set_reflection_property_value('data', array('test1' => 'value1', 'test2' => 'value2'));

        $value = array('is_length_6' => TRUE);
        $this->set_reflection_property_value('result', array('test1' => TRUE, 'test2' => $value));

        $this->assertTrue($this->class->is_valid());
    }

    /**
     * Test that is_valid() returns TRUE if no check failed and is_fully_checked returns TRUE.
     *
     * @depends testIsFullyCheckedReturnsTrueWhenAllDataKeysHaveBeenChecked
     * @covers  Lunr\Flare\Verification::is_valid
     */
    public function testIsValidReturnsTrueIfNoCheckFailedAndIsFullyCheckedIsTrue()
    {
        $this->set_reflection_property_value('identifier', 'testrun');

        $this->set_reflection_property_value('data', array('test1' => 'value1', 'test2' => 'value2'));

        $value = array('is_length_6' => TRUE);
        $this->set_reflection_property_value('result', array('test1' => TRUE, 'test2' => $value));

        $this->assertTrue($this->class->is_valid());
    }

}

?>
