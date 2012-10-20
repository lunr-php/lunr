<?php

/**
 * (Sample) Localization Configuration File
 * This config file contains localization config values needed
 * by the l10n libraries, including:
 * <ul>
 * <li>Localization Domain</li>
 * <li>Location of the language files</li>
 * <li>Default language</li>
 * <li>...</li>
 * </ul>
 * You can override these values in an application
 * specific config file.
 *
 * PHP Version 5.3
 *
 * @category   Config
 * @package    L10n
 * @subpackage Config
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

$config['l10n'] = array();

/**
 * Localization Domain
 * @global String $config['l10n']['domain']
 */
$config['l10n']['domain'] = 'Lunr';

/**
 * Language file location
 *
 * By default this points to a top-level 'l10n' directory.
 *
 * @global String $config['l10n']['locales']
 */
$config['l10n']['locales'] = dirname(__FILE__) . '/../../l10n';

/**
 * Default interface language (POSIX locale)
 * @global String $config['l10n']['default_language']
 */
$config['l10n']['default_language'] = 'en_US';

?>
