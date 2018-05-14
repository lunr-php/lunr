<?php

/**
 * This file contains functionality to dispatch Apple Push Notification Service.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\APNS
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP;

use \ApnsPHP_Message;
use \ApnsPHP_Message_Exception;
use \ApnsPHP_Exception;
use Lunr\Vortex\APNS\APNSPayload;
use Lunr\Vortex\PushNotificationMultiDispatcherInterface;

/**
 * Apple Push Notification Service Push Notification Dispatcher.
 */
class APNSDispatcher implements PushNotificationMultiDispatcherInterface
{

    /**
     * Shared instance of ApnsPHP\Push.
     * @var \ApnsPHP\Push
     */
    protected $apns_push;

    /**
     * Apns Message instance
     * @var \ApnsPHP\Message
     */
    protected $apns_message;

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger    Shared instance of a Logger.
     * @param ApnsPHP\Push    $apns_push Apns Push instance.
     */
    public function __construct($logger, $apns_push)
    {
        $this->logger    = $logger;
        $this->apns_push = $apns_push;

        $this->reset();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->apns_push);
        unset($this->apns_message);
        unset($this->logger);
    }

    /**
     * Reset the variable members of the class.
     *
     * @return void
     */
    protected function reset()
    {
        unset($this->apns_message);
    }

    /**
     * Return a new APNS message.
     *
     * @codeCoverageIgnore
     *
     * @return ApnsPHP_Message
     */
    protected function get_new_apns_message()
    {
        return new ApnsPHP_Message();
    }

    /**
     * Push the notification.
     *
     * @param APNSPayload $payload   Payload object
     * @param array       $endpoints Endpoints to send to in this batch
     *
     * @return APNSResponse $return Response object
     */
    public function push($payload, &$endpoints)
    {
        // Create message
        $tmp_payload = json_decode($payload->get_payload(), TRUE);

        $this->apns_message = $this->get_new_apns_message();

        try
        {
            if (!empty($tmp_payload['alert']))
            {
                $this->apns_message->setText($tmp_payload['alert']);
            }

            if (!empty($tmp_payload['sound']))
            {
                $this->apns_message->setSound($tmp_payload['sound']);
            }

            if (!empty($tmp_payload['badge']))
            {
                $this->apns_message->setBadge($tmp_payload['badge']);
            }

            if (!empty($tmp_payload['custom_data']))
            {
                foreach ($tmp_payload['custom_data'] as $key => $value)
                {
                    $this->apns_message->setCustomProperty($key, $value);
                }
            }
        }
        catch (ApnsPHP_Message_Exception $e)
        {
            $this->logger->warning($e->getMessage());
        }

        // Add endpoints
        $invalid_endpoints = [];

        foreach ($endpoints as $endpoint)
        {
            try
            {
                $this->apns_message->addRecipient($endpoint);
            }
            catch (ApnsPHP_Message_Exception $e)
            {
                $invalid_endpoints[] = $endpoint;

                $this->logger->warning($e->getMessage());
            }
        }

        // Send message
        try
        {
            $this->apns_push->add($this->apns_message);
            $this->apns_push->connect();
            $this->apns_push->send();
            $this->apns_push->disconnect();

            $errors = $this->apns_push->getErrors();
        }
        catch (ApnsPHP_Exception $e)
        {
            $errors = NULL;

            $context = [ 'error' => $e->getMessage() ];
            $this->logger->warning('Dispatching push notification failed: {error}', $context);
        }

        // Return response
        $response = new APNSResponse($this->logger, $endpoints, $invalid_endpoints, $errors);

        $this->reset();

        return $response;
    }

}

?>
