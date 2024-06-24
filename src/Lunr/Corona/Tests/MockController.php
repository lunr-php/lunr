<?php

/**
 * This file contains a Mock class for Lunr's Controller Class
 * used by the Unit tests.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Controller;

/**
 * View Mock class
 */
class MockController extends Controller
{

    /**
     * Constructor.
     *
     * @param Request  $request  Shared instance of the Request class
     * @param Response $response Shared instance of the Response class
     */
    public function __construct($request, $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Mock method that does nothing.
     *
     * @return void
     */
    public function foo()
    {
        // do nothing
    }

    /**
     * Mock static method that does nothing.
     *
     * @return void
     */
    public static function bar()
    {
        // do nothing
    }

}

?>
