<?php

/**
 * This file contains Android Push Notification Service configuration
 * values.
 *
 * PHP Version 5.3
 *
 * @category   Config
 * @package    Core
 * @subpackage Config
 * @author     Jose viso <jose@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

/**
 * Android Push Notification Service Settings
 * @global array $config['blackberrygcm']
 */
$config['blackberrygcm'] = array();

/**
 * API key for GCM which replaces the Google Authentication Token of C2DM
 * @global String $config['blackberrygcm']['api_key']
 */
$config['blackberrygcm']['api_key'] = '';

/**
 * Account type.
 * Possible options are:
 * <ul>
 * <li>GOOGLE</li>
 * <li>HOSTED</li>
 * <li>HOSTED_OR_GOOGLE</li>
 * </ul>
 * @global String $config['blackberrygcm']['account_type']
 */
$config['blackberrygcm']['account_type'] = 'HOSTED_OR_GOOGLE';

/**
 * Google servers URL for sending the push notification to the device
 * @global String $config['blackberrygcm']['google_send_url']
 */
$config['blackberrygcm']['google_send_url'] = 'https://android.googleapis.com/gcm/send';

/**
 * Collapse key (Arbitrary string used to collapse a group of like messages when
 *  the device is offline, so that only the last message gets sent to the client)
 * @global String $config['blackberrygcm']['collapse_key']
 */
$config['blackberrygcm']['collapse_key'] = '';

/**
 * Username
 * @global String $config['blackberrygcm']['username']
 */
$config['blackberrygcm']['username'] = '';

/**
 * Password
 * @global String $config['blackberrygcm']['password']
 */
$config['blackberrygcm']['password'] = '';

/**
 * Path to log-file for logging PUSH errors
 * @global String $config['blackberrygcm']['log']
 */
$config['blackberrygcm']['log'] = '/var/log/httpd';

?>
