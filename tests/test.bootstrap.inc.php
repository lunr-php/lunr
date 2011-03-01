<?php

$base = dirname(__FILE__) . "/..";

set_include_path(
    $base . "/config:" .
    $base . "/system/config:" .
    $base . "/system/libraries/core:" .
    $base . "/system/libraries/db:" .
    $base . "/system/libraries/l10n:" .
    $base . "/system/libraries/third-party:" .
    $base . "/system/libraries/web:" .
    $base . "/system/models:" .
    $base . "/application/libraries/enums:" .
    $base . "/application/libraries/core:" .
    $base . "/application/libraries/db:" .
    $base . "/application/controllers:" .
    $base . "/application/models:" .
    $base . "/application/libraries" .
    get_include_path()
);

?>
