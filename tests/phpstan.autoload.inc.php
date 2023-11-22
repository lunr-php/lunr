<?php

/**
 * PHPStan bootstrap file.
 *
 * Set include path and initialize autoloader.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

$base = __DIR__ . '/..';

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

// Define application config lookup path
$paths = [
    get_include_path(),
    $base . '/config',
    $base . '/src',
];

set_include_path(
    implode(':', $paths)
);

?>
