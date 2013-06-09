<?php

/**
 * PHPUnit bootstrap file.
 *
 * Set include path and initialize autoloader.
 *
 * PHP Version 5.3
 *
 * @category   Loaders
 * @package    Tests
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

$base = dirname(__FILE__) . '/..';

set_include_path(
    $base . '/src:' .
    $base . '/config:' .
    $base . '/system/config:' .
    $base . '/system:' .
    $base . '/tests:' .
    $base . '/tests/mocks:' .
    $base . '/tests/statics:' .
    $base . '/tests/system:' .
    $base . '/application/libraries/enums:' .
    $base . '/application/libraries/core:' .
    $base . '/application/libraries/db:' .
    $base . '/application/controllers:' .
    $base . '/application/models:' .
    $base . '/application/libraries:' .
    $base . '/application/views:' .
    get_include_path()
);

// Load and setup class file autloader
require_once 'Lunr/Core/Autoloader.php';

$autoloader = new Lunr\Core\Autoloader();
$autoloader->register();

?>
