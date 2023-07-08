<?php

/**
 * This file contains the compact json view class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use Lunr\Core\Configuration;

/**
 * View class for displaying JSON return values, excluding NULL values.
 */
class CompactJsonView extends JsonView
{

    /**
     * Constructor.
     *
     * @param Request       $request       Shared instance of the Request class
     * @param Response      $response      Shared instance of the Response class
     * @param Configuration $configuration Shared instance of the Configuration class
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
