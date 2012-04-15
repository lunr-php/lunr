<?php

/**
 * This file contains the VerificationResultTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;

/**
 * This class contains the tests for result checking methods.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Verification
 */
class VerificationResultTest extends VerificationTest
{

    /**
     * Test that is_overchecked() returns FALSE when there are no superfluous elements being checked.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testSuperfluousIsEmptyByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_overchecked
     */
    public function testIsOvercheckedReturnsFalseWhenSuperfluousIsEmpty()
    {
        $method = $this->verification_reflection->getMethod('is_overchecked');
        $method->setAccessible(TRUE);

        $this->assertFalse($method->invokeArgs($this->verification, array('')));
    }

    /**
     * Test that is_overchecked() returns TRUE when there are superfluous elements being checked.
     *
     * @covers Lunr\Libraries\Core\Verification::is_overchecked
     */
    public function testIsOvercheckedReturnsTrueWhenSuperfluousIsNotEmpty()
    {
        $method = $this->verification_reflection->getMethod('is_overchecked');
        $method->setAccessible(TRUE);

        $property = $this->verification_reflection->getProperty('superfluous');
        $property->setAccessible(TRUE);
        $property->setValue($this->verification, array('test1', 'test2'));

        $this->logger->expects($this->exactly(2))
                     ->method('log_errorln');

        $this->assertTrue($method->invokeArgs($this->verification, array('')));
    }

    /**
     * Test that is_fully_checked() returns TRUE when all data keys have been checked.
     *
     * @param array $data   dataset to check
     * @param array $result check results
     *
     * @dataProvider isFullyCheckedProvider
     * @covers       Lunr\Libraries\Core\Verification::is_fully_checked
     */
    public function testIsFullyCheckedReturnsTrueWhenAllDataKeysHaveBeenChecked($data, $result)
    {
        $checked_data = $this->verification_reflection->getProperty('data');
        $checked_data->setAccessible(TRUE);
        $checked_data->setValue($this->verification, $data);

        $results = $this->verification_reflection->getProperty('result');
        $results->setAccessible(TRUE);
        $results->setValue($this->verification, $result);

        $method = $this->verification_reflection->getMethod('is_fully_checked');
        $method->setAccessible(TRUE);

        $this->assertTrue($method->invokeArgs($this->verification, array('')));
    }

    /**
     * Test that is_fully_checked() returns FALSE when not all data keys have been checked.
     *
     * @param array $data   dataset to check
     * @param array $result check results
     *
     * @dataProvider isNotFullyCheckedProvider
     * @covers       Lunr\Libraries\Core\Verification::is_fully_checked
     */
    public function testIsFullyCheckedReturnsFalseWhenNotAllDataKeysHaveBeenChecked($data, $result)
    {
        $checked_data = $this->verification_reflection->getProperty('data');
        $checked_data->setAccessible(TRUE);
        $checked_data->setValue($this->verification, $data);

        $results = $this->verification_reflection->getProperty('result');
        $results->setAccessible(TRUE);
        $results->setValue($this->verification, $result);

        $method = $this->verification_reflection->getMethod('is_fully_checked');
        $method->setAccessible(TRUE);

        $this->logger->expects($this->exactly(sizeof($data)-sizeof($result)))
                     ->method('log_errorln');

        $this->assertFalse($method->invokeArgs($this->verification, array('')));
    }

    /**
     * Test that is_valid() returns FALSE if there is no identifier set.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testIdentifierIsEmptyStringByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_valid
     */
    public function testIsValidReturnsFalseIfIdentifierIsEmpty()
    {
        $this->assertFalse($this->verification->is_valid());
    }

    /**
     * Test that is_valid() returns FALSE when check_superfluous is TRUE and is_overchecked Returnes TRUE.
     *
     * @depends testIsOvercheckedReturnsTrueWhenSuperfluousIsNotEmpty
     * @covers  Lunr\Libraries\Core\Verification::is_valid
     */
    public function testIsValidReturnsFalseIfCheckSuperfluousEnabledAndIsOvercheckedTrue()
    {
        $identifier = $this->verification_reflection->getProperty('identifier');
        $identifier->setAccessible(TRUE);
        $identifier->setValue($this->verification, 'testrun');

        $enabled = $this->verification_reflection->getProperty('check_superfluous');
        $enabled->setAccessible(TRUE);
        $enabled->setValue($this->verification, TRUE);

        $property = $this->verification_reflection->getProperty('superfluous');
        $property->setAccessible(TRUE);
        $property->setValue($this->verification, array('test1', 'test2'));

        $this->assertFalse($this->verification->is_valid());
    }

    /**
     * Test that is_valid() returns FALSE when check_remaining is TRUE and is_fully_checked Returnes FALSE.
     *
     * @depends testIsFullyCheckedReturnsFalseWhenNotAllDataKeysHaveBeenChecked
     * @covers  Lunr\Libraries\Core\Verification::is_valid
     */
    public function testIsValidReturnsFalseIfCheckRemainingEnabledAndIsFullyCheckedFalse()
    {
        $identifier = $this->verification_reflection->getProperty('identifier');
        $identifier->setAccessible(TRUE);
        $identifier->setValue($this->verification, 'testrun');

        $checked_data = $this->verification_reflection->getProperty('data');
        $checked_data->setAccessible(TRUE);
        $checked_data->setValue($this->verification, array('test' => 'value'));

        $results = $this->verification_reflection->getProperty('result');
        $results->setAccessible(TRUE);
        $results->setValue($this->verification, array());

        $this->assertFalse($this->verification->is_valid());
    }

    /**
     * Test that is_valid() returns FALSE if a check failed.
     *
     * @covers Lunr\Libraries\Core\Verification::is_valid
     */
    public function testIsValidReturnsFalseIfACheckFailed()
    {
        $identifier = $this->verification_reflection->getProperty('identifier');
        $identifier->setAccessible(TRUE);
        $identifier->setValue($this->verification, 'testrun');

        $enabled = $this->verification_reflection->getProperty('check_remaining');
        $enabled->setAccessible(TRUE);
        $enabled->setValue($this->verification, FALSE);

        $checked_data = $this->verification_reflection->getProperty('data');
        $checked_data->setAccessible(TRUE);
        $checked_data->setValue($this->verification, array('test1' => 'value1', 'test2' => 'value2'));

        $results = $this->verification_reflection->getProperty('result');
        $results->setAccessible(TRUE);
        $value = array('is_length_5' => FALSE);
        $results->setValue($this->verification, array('test1' => $value, 'test2' => $value));

        $this->logger->expects($this->exactly(2))
                     ->method('log_errorln');

        $this->assertFalse($this->verification->is_valid());
    }

    /**
     * Test that is_valid() returns TRUE if no check failed.
     *
     * @covers Lunr\Libraries\Core\Verification::is_valid
     */
    public function testIsValidReturnsTrueIfNoCheckFailed()
    {
        $identifier = $this->verification_reflection->getProperty('identifier');
        $identifier->setAccessible(TRUE);
        $identifier->setValue($this->verification, 'testrun');

        $enabled = $this->verification_reflection->getProperty('check_remaining');
        $enabled->setAccessible(TRUE);
        $enabled->setValue($this->verification, FALSE);

        $checked_data = $this->verification_reflection->getProperty('data');
        $checked_data->setAccessible(TRUE);
        $checked_data->setValue($this->verification, array('test1' => 'value1', 'test2' => 'value2'));

        $results = $this->verification_reflection->getProperty('result');
        $results->setAccessible(TRUE);
        $value = array('is_length_6' => TRUE);
        $results->setValue($this->verification, array('test1' => TRUE, 'test2' => $value));

        $this->assertTrue($this->verification->is_valid());
    }

    /**
     * Test that is_valid() returns TRUE if no check failed and is_overchecked returns FALSE.
     *
     * @depends testIsOvercheckedReturnsFalseWhenSuperfluousIsEmpty
     * @covers  Lunr\Libraries\Core\Verification::is_valid
     */
    public function testIsValidReturnsTrueIfNoCheckFailedAndIsOvercheckedIsFalse()
    {
        $identifier = $this->verification_reflection->getProperty('identifier');
        $identifier->setAccessible(TRUE);
        $identifier->setValue($this->verification, 'testrun');

        $enabled1 = $this->verification_reflection->getProperty('check_superfluous');
        $enabled1->setAccessible(TRUE);
        $enabled1->setValue($this->verification, TRUE);

        $enabled2 = $this->verification_reflection->getProperty('check_remaining');
        $enabled2->setAccessible(TRUE);
        $enabled2->setValue($this->verification, FALSE);

        $checked_data = $this->verification_reflection->getProperty('data');
        $checked_data->setAccessible(TRUE);
        $checked_data->setValue($this->verification, array('test1' => 'value1', 'test2' => 'value2'));

        $results = $this->verification_reflection->getProperty('result');
        $results->setAccessible(TRUE);
        $value = array('is_length_6' => TRUE);
        $results->setValue($this->verification, array('test1' => TRUE, 'test2' => $value));

        $this->assertTrue($this->verification->is_valid());
    }

    /**
     * Test that is_valid() returns TRUE if no check failed and is_fully_checked returns TRUE.
     *
     * @depends testIsFullyCheckedReturnsTrueWhenAllDataKeysHaveBeenChecked
     * @covers  Lunr\Libraries\Core\Verification::is_valid
     */
    public function testIsValidReturnsTrueIfNoCheckFailedAndIsFullyCheckedIsTrue()
    {
        $identifier = $this->verification_reflection->getProperty('identifier');
        $identifier->setAccessible(TRUE);
        $identifier->setValue($this->verification, 'testrun');

        $checked_data = $this->verification_reflection->getProperty('data');
        $checked_data->setAccessible(TRUE);
        $checked_data->setValue($this->verification, array('test1' => 'value1', 'test2' => 'value2'));

        $results = $this->verification_reflection->getProperty('result');
        $results->setAccessible(TRUE);
        $value = array('is_length_6' => TRUE);
        $results->setValue($this->verification, array('test1' => TRUE, 'test2' => $value));

        $this->assertTrue($this->verification->is_valid());
    }

}

?>
