<?php

/**
 * This file contains the JsonEnumTraitTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\JsonEnumTrait;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the JsonEnumTrait.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\JsonEnumTrait
 */
class JsonEnumTraitTest extends LunrBaseTest
{

    /**
     * Instance of the JsonEnumTrait.
     * @var JsonEnumTrait
     */
    protected $class;

    /**
     * Reflection instance of the JsonEnumTrait.
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Test case constructor.
     */
    public function setUp()
    {
        $this->class      = $this->getObjectForTrait('Lunr\Corona\JsonEnumTrait');
        $this->reflection = new ReflectionClass($this->class);
    }

    /**
     * Test case destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Test that there are no json enums set by default.
     */
    public function testJsonNullByDefault()
    {
        $this->assertNull($this->get_reflection_property_value('json'));
    }

    /**
     * Test setting json enums.
     *
     * @covers Lunr\Corona\JsonEnumTrait::set_json_enums
     */
    public function testSetJsonEnums()
    {
        $JSON['version'] = 'v';

        $this->class->set_json_enums($JSON);

        $this->assertSame($JSON, $this->get_reflection_property_value('json'));
    }

}

?>
