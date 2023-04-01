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
    require_once $base . '/vendor/autoload.php';
}
else
{
    // workaround for https://github.com/phpstan/phpstan/issues/7526
    function phpstan_issue_7526_workaround($class)
    {
        autoload_psr($class);
    }

    spl_autoload_register('phpstan_issue_7526_workaround');

    // Load decomposer autoloade.
    require_once $base . '/decomposer.autoload.inc.php';
}

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
