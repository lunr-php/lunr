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
 * @copyright  2010-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;

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

    /**
     * Shared instance of the Response class.
     * @var Response
     */
    protected $response;

    /**
     * Set of error enums.
     * @var array
     */
    protected $error;

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

    /**
     * Store a set of error enums.
     *
     * @param array &$enums An array of error enums
     *
     * @return void
     */
    public function set_error_enums(&$enums)
    {
        $this->error =& $enums;
    }

}

?>
