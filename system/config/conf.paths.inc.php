<?php

/**
 * Path / Location / URL configuration file
 * This config file contains the common path variables, like:
 * <ul>
 * <li>Base URL</li>
 * <li>Protocol</li>
 * <li>Log Paths</li>
 * <li>...</li>
 * </ul>
 *
 * PHP Version 5.3
 *
 * @category   Config
 * @package    Core
 * @subpackage Config
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

/**
 * The path of the called script
 * @global String $config['base_path']
 */
$config['base_path'] = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);

/**
 * The protocol used by the request (HTTP|HTTPS)
 * @global String $config['protocol']
 */
$config['protocol'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
                      ? 'https'
                      : 'http';

/**
 * The fully qualified domain name used for the call
 * @global String $config['base_url']
 */
$config['base_url']  = $config['protocol'] . '://'.$_SERVER['SERVER_NAME'];
//$config['base_url'] .= ":" . $_SERVER['SERVER_PORT'];
$config['base_url'] .= $config['base_path'];

/**
 * Directory containing static files (javascript, css, images, etc)
 * @global String $config['path']['statics']
 */
$config['path']['statics'] = "/statics";

/**
 * Array of logfile paths
 * @global Array $config['log']
 */
$config['log'] = array();

/**
 * Default path to invalid input logs
 * @global String $config['log']['invalid_input']
 */
$config['log']['invalid_input'] = '/var/log/httpd/';

/**
 * Default path to performance logs
 * @global String $config['log']['performance']
 */
$config['log']['performance'] = '/var/log/httpd/';

?>
