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
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
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

    /**
     * Instance of the Request class.
     * @var RequestInterface
     */
    protected $request;

    /**
     * Instance of the FilesystemAccessObject class.
     * @var FilesystemAccessObjectInterface
     */
    protected $fao;

    /**
     * Constructor.
     *
     * @param RequestInterface                $request Instance of the Request class.
     * @param FilesystemAccessObjectInterface $fao     Instance of the FilesystemAccessObject class.
     */
    public function __construct($request, $fao)
    {
        $this->request = $request;
        $this->fao     = $fao;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->request);
        unset($this->fao);
    }

    /**
     * Get the controller responsible for the request.
     *
     * @param String  $src       Project subfolder to look for controllers in.
     * @param Array   $list      List of controller names
     * @param Boolean $blacklist Whether to use the controller list as blacklist or whitelist
     *
     * @return String $controller Fully qualified name of the responsible controller.
     */
    public function get_controller($src, $list = [], $blacklist = TRUE)
    {
        $name = $this->request->controller . 'controller';

        if ($name == 'controller')
        {
            return '';
        }

        if (($blacklist === TRUE) && in_array($this->request->controller, $list))
        {
            return '';
        }
        elseif (($blacklist === FALSE) && !in_array($this->request->controller, $list))
        {
            return '';
        }

        $matches = $this->fao->find_matches("/^.+$name.php/i", $src);

        if (empty($matches) === TRUE)
        {
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
