<?php

/**
 * A correct Lunr config file.
 *
 * PHP Version 5.3
 *
 * @category   Configuration
 * @package    Tests
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

$database = array();

## Live Database
$database['live'] = array();

$database['live']['rw_host']  = '10.0.0.22';
$database['live']['ro_host']  = '10.0.0.10';
$database['live']['username'] = 'schiphol';
$database['live']['password'] = '@Sch1ph0l';
$database['live']['database'] = 'MidSchipDB';
$database['live']['driver']   = 'mysql';

$db = $database['live'];

?>
