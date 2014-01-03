<?php

/**
 * A correct Lunr config file.
 *
 * PHP Version 5.3
 *
 * @category   Configuration
 * @package    Tests
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
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
