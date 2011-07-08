<?php

/**
 * This file contains OAuth configuration
 * values for services like Twitter, LinkedIn, etc, like:
 * <ul>
 * <li>consumersecret</li>
 * <li>consumerkey</li>
 * <li>accesstokenurl</li>
 * <li>authurl</li>
 * <li>...</li>
 * </ul>
 *
 * PHP Version 5.3
 *
 * @category   Config
 * @package    Core
 * @subpackage Config
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 */

/**
 * OAuth Services Settings
 * @global Array $config['oauth']
 */
$config['oauth'] = array();

/**
 * OAuth Error Log
 * @global String $config['oauth']['log']
 */
$config['oauth']['log'] = '';

/**
 * Twitter Service Settings
 * @global Array $config['oauth']['twitter']
 */
$config['oauth']['twitter'] = array();

/**
 * Consumer Secret for Twitter
 * @global String $config['oauth']['twitter']['consumersecret']
 */
$config['oauth']['twitter']['consumersecret'] = '';

/**
 * Consumer Key for Twitter
 * @global String $config['oauth']['twitter']['consumerkey']
 */
$config['oauth']['twitter']['consumerkey'] = '';

/**
 * URL where to request the 'request token' for Twitter
 * @global String $config['oauth']['twitter']['requesttokenurl']
 */
$config['oauth']['twitter']['requesttokenurl'] = 'http://twitter.com/oauth/request_token';

/**
 * URL where to request the 'access token' for Twitter
 * @global String $config['oauth']['twitter']['accesstokenurl']
 */
$config['oauth']['twitter']['accesstokenurl'] = 'http://twitter.com/oauth/access_token';

/**
 * URL where to send the user for authorization on Twitter
 * @global String $config['oauth']['twitter']['authurl']
 */
$config['oauth']['twitter']['authurl'] = 'http://twitter.com/oauth/authorize';

/**
 * URL where to verify and retrieve the user's credentials on Twitter
 * @global String $config['oauth']['twitter']['verify_url']
 */
$config['oauth']['twitter']['verify_url'] = 'http://twitter.com/account/verify_credentials.json';

/**
 * URL where to publish on Twitter
 * @global String $config['oauth']['twitter']['publish_url']
 */
$config['oauth']['twitter']['publish_url'] = 'http://twitter.com/statuses/update.json';

/**
 * Linkedin Service Settings
 * @global Array $config['oauth']['linkedin']
 */
$config['oauth']['linkedin'] = array();

/**
 * Consumer Secret for LinkedIn
 * @global String $config['oauth']['linkedin']['consumersecret']
 */
$config['oauth']['linkedin']['consumersecret'] = '';

/**
 * Consumer Key for LinkedIn
 * @global String $config['oauth']['linkedin']['consumerkey']
 */
$config['oauth']['linkedin']['consumerkey'] = '';

/**
 * URL where to request the 'request token' for LinkedIn
 * @global String $config['oauth']['linkedin']['requesttokenurl']
 */
$config['oauth']['linkedin']['requesttokenurl'] = 'https://api.linkedin.com/uas/oauth/requestToken';

/**
 * URL where to request the 'access token' for LinkedIn
 * @global String $config['oauth']['linkedin']['accesstokenurl']
 */
$config['oauth']['linkedin']['accesstokenurl'] = 'https://api.linkedin.com/uas/oauth/accessToken';

/**
 * URL where to send the user for authorization on LinkedIn
 * @global String $config['oauth']['linkedin']['authurl']
 */
$config['oauth']['linkedin']['authurl'] = 'https://api.linkedin.com/uas/oauth/authorize';

/**
 * URL where to verify and retrieve the user's credentials on LinkedIn
 * @global String $config['oauth']['linkedin']['verify_url']
 */
$config['oauth']['linkedin']['verify_url'] = 'http://api.linkedin.com/v1/people/~';

/**
 * URL where to publish on LinkedIn
 * @global String $config['oauth']['linkedin']['publish_url']
 */
$config['oauth']['linkedin']['publish_url'] = 'http://api.linkedin.com/v1/people/~/shares';

/**
 * Default visibility value for your LinkedIn messages
 * Possible values are 'anyone' and 'connections-only'.
 * The default value is 'anyone'
 * @global String $config['oauth']['linkedin']['visibility']
 */
$config['oauth']['linkedin']['visibility'] = 'anyone';

?>
