<?php

/**
 * PHPUnit bootstrap file.
 *
 * Set include path and initialize autoloader.
 *
 * PHP Version 5.4
 *
 * @category   Loaders
 * @package    Tests
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

$base = __DIR__ . '/..';

set_include_path(
    $base . '/src:' .
    $base . '/src/Requests:' .
    $base . '/src/Resque:' .
    $base . '/config:' .
    $base . '/system:' .
    $base . '/tests:' .
    $base . '/tests/statics:' .
    $base . '/tests/statics/Core:' .
    get_include_path()
);

if (file_exists('vendor/autoload.php') == TRUE)
{
    // Load composer autoloader.
    require_once 'vendor/autoload.php';
}
else
{
    // Load and setup class file autloader
    require_once 'Lunr/Core/Autoloader.php';

    $autoloader = new Lunr\Core\Autoloader();
    $autoloader->register();

    // Include libraries
    include_once 'Psr-Log-1.0.2.php';
    include_once 'PHPMailer-6.0.0rc4.php';
    include_once 'ApnsPHP-1.0.1.91.php';
    include_once 'Requests-1.7.0.php';
    include_once 'PHP-Resque-1.2.92.php';
    include_once 'Psr-Cache-1.0.1.php';
}

if (defined('TEST_STATICS') === FALSE)
{
    define('TEST_STATICS', __DIR__ . '/statics');
}

?>
