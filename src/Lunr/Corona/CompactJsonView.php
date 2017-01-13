<?php

/**
 * This file contains the compact json view class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * View class for displaying JSON return values, excluding NULL values.
 */
class CompactJsonView extends JsonView
{

    /**
     * Constructor.
     *
     * @param RequestInterface $request       Shared instance of the Request class
     * @param Response         $response      Shared instance of the Response class
     * @param Configuration    $configuration Shared instance of to the Configuration class
     */
    public function __construct($request, $response, $configuration)
    {
        parent::__construct($request, $response, $configuration);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Prepare the response data before using it for generating the output.
     *
     * @param mixed $data Response data to prepare
     *
     * @return mixed $return Prepared response data
     */
    protected function prepare_data($data)
    {
        foreach ($data as $key => $value)
        {
            if (is_array($value))
            {
                $data[$key] = $this->prepare_data($value);
            }
            elseif (is_null($value))
            {
                unset($data[$key]);
            }
        }

        return $data;
    }

}

?>
