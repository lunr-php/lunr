<?php

/**
 * This file contains low level Preview API methods for Contentful.
 *
 * @package    Lunr\Spark\Contentful
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful;

use Lunr\Spark\CentralAuthenticationStore;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Session;

/**
 * Low level Contentful Preview API methods for Spark
 */
class PreviewApi extends DeliveryApi
{

    /**
     * Content Preview API URL.
     * @var string
     */
    protected const URL = 'https://preview.contentful.com';

    /**
     * Constructor.
     *
     * @param CentralAuthenticationStore $cas    Shared instance of the credentials store
     * @param LoggerInterface            $logger Shared instance of a Logger class.
     * @param Session                    $http   Shared instance of the Requests\Session class.
     */
    public function __construct($cas, $logger, $http)
    {
        parent::__construct($cas, $logger, $http);
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
