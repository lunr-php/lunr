<?php

/**
 * This file contains the FrontController class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage MVC
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * Controller class
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage MVC
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class FrontController
{

    use ErrorEnumTrait;

    /**
     * Instance of the Request class.
     * @var RequestInterface
     */
    protected $request;

    /**
     * Instance of the Response class.
     * @var Response
     */
    protected $response;

    /**
     * Instance of the FilesystemAccessObject class.
     * @var FilesystemAccessObjectInterface
     */
    protected $fao;

    /**
     * Constructor.
     *
     * @param RequestInterface                $request  Instance of the Request class.
     * @param Response                        $response Instance of the Response class.
     * @param FilesystemAccessObjectInterface $fao      Instance of the FilesystemAccessObject class.
     */
    public function __construct($request, $response, $fao)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->fao      = $fao;
        $this->error    = array();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->request);
        unset($this->response);
        unset($this->fao);
        unset($this->error);
    }

    /**
     * Get the controller responsible for the request.
     *
     * @param String $src Project subfolder to look for controllers in.
     *
     * @return String $controller Fully qualified name of the responsible controller.
     */
    public function get_controller($src)
    {
        $name = $this->request->controller . 'controller';

        $matches = $this->fao->find_matches("/^.+$name.php/i", $src);

        if (empty($matches))
        {
            $this->response->errmsg = 'Undefined controller';

            if (isset($this->error['not_implemented']))
            {
                $this->response->return_code = $this->error['not_implemented'];
            }

            return '';
        }

        $search  = [ '.php', $src, '/' ];
        $replace = [ '', '', '\\' ];

        return ltrim(str_replace($search, $replace, $matches[0]), '\\');
    }

    /**
     * Dispatch to the found controller.
     *
     * @param Controller $controller Instance of the responsible Controller class.
     *
     * @return void
     */
    public function dispatch($controller)
    {
        call_user_func_array(array($controller, $this->request->method), $this->request->params);
    }

}

?>
