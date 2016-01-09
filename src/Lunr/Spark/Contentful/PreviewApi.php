<?php

/**
 * This file contains low level Preview API methods for Contentful.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Contentful
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2015-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful;

/**
 * Low level Contentful Preview API methods for Spark
 */
class PreviewApi extends DeliveryApi
{

    /**
     * Content Preview API URL.
     * @var String
     */
    const URL = 'https://preview.contentful.com/spaces/';

    /**
     * Constructor.
     *
     * @param \Lunr\Spark\CentralAuthenticationStore $cas    Shared instance of the credentials store
     * @param \Psr\Log\LoggerInterface               $logger Shared instance of a Logger class.
     * @param \Lunr\Network\Curl                     $curl   Shared instance of the Curl class.
     */
    public function __construct($cas, $logger, $curl)
    {
        parent::__construct($cas, $logger, $curl);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

}

?>
