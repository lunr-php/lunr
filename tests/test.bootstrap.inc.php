<?php

/**
 * PHPUnit bootstrap file.
 *
 * Set include path and initialize autoloader.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

$base = __DIR__ . '/..';

set_include_path(
    $base . '/src:' .
    $base . '/config:' .
    $base . '/tests:' .
    $base . '/tests/statics:' .
    $base . '/tests/statics/Core:' .
    get_include_path()
);

if (file_exists($base . '/vendor/autoload.php') == TRUE)
{
    // Load composer autoloader.
    require_once $base . '/vendor/autoload.php';
}
else
{
    // Load decomposer autoloade.
    require_once $base . '/decomposer.autoload.inc.php';
}

if (defined('TEST_STATICS') === FALSE)
{
    define('TEST_STATICS', __DIR__ . '/statics');
}

?>
