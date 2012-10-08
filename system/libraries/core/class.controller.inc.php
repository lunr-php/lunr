<?php

/**
 * This file contains an abstract controller class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;

/**
 * Controller class
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class Controller
{

    /**
     * Reference to the Response class.
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
     * @param Response &$response Reference to the Response class
     */
    public function __construct(&$response)
    {
        $this->response =& $response;
        $this->error = array();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->error);
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
