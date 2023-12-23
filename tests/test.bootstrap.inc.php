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

// Define application config lookup path
$paths = [
    get_include_path(),
    $base . '/src',
];

set_include_path(
    implode(':', $paths)
);

if (file_exists($base . '/vendor/autoload.php') == TRUE)
{
    // Load composer autoloader.
    $autoload_file = $base . '/vendor/autoload.php';
}
else
{
    // Load decomposer autoloade.
    $autoload_file = $base . '/decomposer.autoload.inc.php';
}

require_once $autoload_file;

if (defined('TEST_STATICS') === FALSE)
{
    define('TEST_STATICS', __DIR__ . '/statics');
}

?>
