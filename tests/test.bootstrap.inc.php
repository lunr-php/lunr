<?php

$base = dirname(__FILE__) . "/..";

set_include_path(
    $base . "/config:" .
    $base . "/system/config:" .
    $base . "/system:" .
    $base . "/application/libraries/enums:" .
    $base . "/application/libraries/core:" .
    $base . "/application/libraries/db:" .
    $base . "/application/controllers:" .
    $base . "/application/models:" .
    $base . "/application/libraries:" .
    $base . "/application/views:" .
    get_include_path()
);

// Load and setup class file autloader
include_once("libraries/core/class.autoloader.inc.php");
spl_autoload_register("Lunr\Libraries\Core\Autoloader::load");


?>
