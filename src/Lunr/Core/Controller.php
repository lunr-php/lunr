<?php

/**
 * This file contains an abstract controller class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core;

/**
 * Controller class
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class Controller
{

    use ErrorEnumTrait;

    /**
     * Shared instance of the Response class.
     * @var Response
     */
    protected $response;

    /**
     * Constructor.
     *
     * @param Response $response Shared instance of the Response class
     */
    public function __construct($response)
    {
        $this->response = $response;
        $this->error    = array();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->error);
        unset($this->response);
    }

    /**
     * Handle unimplemented calls.
     *
     * @param String $name      Method name
     * @param array  $arguments Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $arguments)
    {
        if (isset($this->error['not_implemented']))
        {
            $this->response->return_code = $this->error['not_implemented'];
        }

        $this->response->errmsg = 'Not implemented!';
    }

}

?>
