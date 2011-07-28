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
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Jose viso <jose@m2mobi.com>
 */

/**
 * Android Push Notification Service Settings
 * @global array $config['c2dm']
 */
$config['c2dm'] = array();

/**
 * URL for request authorization token
 * @global String $config['c2dm']['request_token_url']
 */
$config['c2dm']['request_token_url'] = 'https://www.google.com/accounts/ClientLogin';

/**
 * Account type.
 * Possible options are:
 * <ul>
 * <li>GOOGLE</li>
 * <li>HOSTED</li>
 * <li>HOSTED_OR_GOOGLE</li>
 * </ul>
 * @global String $config['c2dm']['account_type']
 */
$config['c2dm']['account_type'] = 'HOSTED_OR_GOOGLE';

/**
 * Google servers URL for sending the push notification to the device
 * @global String $config['c2dm']['google_send_url']
 */
$config['c2dm']['google_send_url'] = 'https://android.apis.google.com/c2dm/send';

/**
 * Message type
 * @global String $config['c2dm']['msg_type']
 */
$config['c2dm']['msg_type'] = '';

/**
 * Username
 * @global String $config['c2dm']['username']
 */
$config['c2dm']['username'] = '';

/**
 * Password
 * @global String $config['c2dm']['password']
 */
$config['c2dm']['password'] = '';

/**
 * Path to log-file for logging PUSH errors
 * @global String $config['c2dm']['log']
 */
$config['c2dm']['log'] = '/var/log/';

?>