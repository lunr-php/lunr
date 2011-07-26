<?php

use Lunr\Mocks\Libraries\Core\MockView;
use Lunr\Mocks\Libraries\L10n\MockL10nProvider;

/**
 * This tests Lunr's View class
 * @covers Lunr\Libraries\Core\View
 */
class ViewTest extends PHPUnit_Framework_TestCase
{

    /**
     * ReflectionClass pointing to Lunr's View Class
     * @var ReflectionClass
     */
    private $view_reflection;

    /**
     * Reference to a View Mock-class
     * @var MockView
     */
    private $view;

    /**
     *
     */
    protected function setUp()
    {
        $this->view_reflection = new ReflectionClass('Lunr\Libraries\Core\View');
        $this->view = new MockView();
    }

    protected function tearDown()
    {
        unset($this->view);
        unset($this->view_reflection);
    }

    /**
     * Tests whether the private data attribute if the view class is empty
     * at the beginning.
     */
    public function testDataEmpty()
    {
        $data = $this->view_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $this->assertEmpty($data->getValue($this->view));
    }

    /**
     * Tests the add_data method of the View class
     * @depends testDataEmpty
     * @covers Lunr\Libraries\Core\View::add_data
     */
    public function testAddData()
    {
        $string = 'value';
        $this->view->add_data('test', $string);
        $data = $this->view_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $array = $data->getValue($this->view);
        $this->assertEquals('value', $array['test']);
    }

    /**
     * Tests the set_l10n_provider method of the View class
     * @covers Lunr\Libraries\Core\View::set_l10n_provider
     */
    public function testSetL10nProvider()
    {
        $provider = new MockL10nProvider('en_US');
        $this->view->set_l10n_provider($provider);
        $set = $this->view_reflection->getProperty('l10n');
        $set->setAccessible(TRUE);
        $this->assertSame($provider, $set->getValue($this->view));
    }

    /**
     * Tests the base_url method of the View class
     * @dataProvider baseUrlProvider
     * @covers Lunr\Libraries\Core\View::base_url
     * @runInSeparateProcess
     */
    public function testBaseUrl($host, $base, $path, $result)
    {
        global $config;
        $config['base_url'] = $host . $base;
        $method = $this->view_reflection->getMethod('base_url');
        $method->setAccessible(TRUE);
        $this->assertEquals($result, $method->invokeArgs($this->view, array($path)));
    }

    /**
     * Tests the statics method of the View class
     * @dataProvider staticsProvider
     * @covers Lunr\Libraries\Core\View::statics
     * @runInSeparateProcess
     */
    public function testStatics($base, $statics, $path, $result)
    {
        global $config;
        $config['base_path'] = $base;
        $config['path']['statics'] = $statics;
        $method = $this->view_reflection->getMethod('statics');
        $method->setAccessible(TRUE);
        $this->assertEquals($result, $method->invokeArgs($this->view, array($path)));
    }

    /**
     * Tests the css_alternate method of the View class
     * @dataProvider cssAlternateProvider
     * @covers Lunr\Libraries\Core\View::css_alternate
     */
    public function testCssAlternate($basename, $alternation_hint, $suffix, $result)
    {
        $method = $this->view_reflection->getMethod('css_alternate');
        $method->setAccessible(TRUE);
        $this->assertEquals($result, $method->invokeArgs($this->view, array($basename, $alternation_hint, $suffix)));
    }

    public function baseUrlProvider()
    {
        $values   = array();
        $values[] = array('http://www.example.org', '/', 'method/param', 'http://www.example.org/method/param');
        $values[] = array('http://www.example.org', '/test/', 'method/param', 'http://www.example.org/test/method/param');
        return $values;
    }

    public function staticsProvider()
    {
        $values   = array();
        $values[] = array('/', 'statics', 'image/test.jpg', '/statics/image/test.jpg');
        $values[] = array('/', '/statics', 'image/test.jpg', '/statics/image/test.jpg');
        $values[] = array('/test/', 'statics', 'image/test.jpg', '/test/statics/image/test.jpg');
        $values[] = array('/test/', '/statics', 'image/test.jpg', '/test/statics/image/test.jpg');
        return $values;
    }

    public function cssAlternateProvider()
    {
        $values   = array();
        $values[] = array('row', 0, '', 'row_even');
        $values[] = array('row', 1, '', 'row_odd');
        $values[] = array('row', 0, 'custom', 'row_custom');
        return $values;
    }
}

?>
