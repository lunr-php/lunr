<?php

/**
 * This file contains the Pagination class. Pagination takes an
 * array of data items, splits them among multiple HTML pages
 * and makes them accessible via a navigation interface.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Web
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 * @copyright  2010-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Web;

/**
 * Pagination class
 *
 * @category   Libraries
 * @package    Web
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 */
class Pagination
{

    /**
     * Cursor pointing to the currently displayed page
     * @var Integer
     */
    private $cursor;

    /**
     * Pagination base url
     * @var String
     */
    private $base_url;

    /**
     * Total number of items
     * @var Integer
     */
    private $total;

    /**
     * Numbers of items shown per page
     * @var Integer
     */
    private $per_page;

    /**
     * Total amount of pages
     * @var Integer
     */
    private $pages_total;

    /**
     * Page links shown before and after the cursor
     * @var Integer
     */
    private $range;

    /**
     * Button Information
     * @var array
     */
    private $buttons;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Default values
        $this->per_page = 25;
        $this->range    = 2;

        $this->buttons                     = array();
        $this->buttons['first']            = array();
        $this->buttons['first']['text']    = '&#8810;';
        $this->buttons['first']['enabled'] = TRUE;

        $this->buttons['previous']            = array();
        $this->buttons['previous']['text']    = '&lt;';
        $this->buttons['previous']['enabled'] = TRUE;

        $this->buttons['next']            = array();
        $this->buttons['next']['text']    = '&gt;';
        $this->buttons['next']['enabled'] = TRUE;

        $this->buttons['last']            = array();
        $this->buttons['last']['text']    = '&#8811;';
        $this->buttons['last']['enabled'] = TRUE;

    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cursor);
        unset($this->base_url);
        unset($this->total);

        unset($this->per_page);
        unset($this->range);
        unset($this->pages_total);

        unset($this->buttons);
    }

    /**
     * Initializes the Pagination.
     *
     * calculates number of pages and builds the Pagination
     *
     * @param array $config The configuration parameters for the Pagination
     *                      The array keys and values data types are the
     *                      following:
     *                      <ul>
     *                        <li>'current_page', Integer (Mandatory)</li>
     *                        <li>'base_url', String (Mandatory)</li>
     *                        <li>'total', Integer (Mandatory, total number
     *                              of items queried)</li>
     *                        <li>'per_page', Integer (Optional, items shown
     *                              per page, set to 25 by default)</li>
     *                        <li>'range', Integer (Optional, cursors lesser
     *                              and bigger shown before and after the
     *                              current cursor, set to 2 by default)</li>
     *                        <li>'text_previous', String (Optional, text
     *                              shown in previous button, set to "&lt;" by
     *                              default)</li>
     *                        <li>'text_separator', String (Optional, text
     *                              shown in separators, set to "..." by
     *                              default)</li>
     *                        <li>'text_next', String (Optional, text shown in
     *                              next button, set to "&gt;" by default)</li>
     *                      </ul>
     *
     * @return void
     */
    public function initialize($config)
    {
        // empty(0) is true and be want to avoid it, so we check if cursor is 0
        if ($config['current_page'] == 0
            || (isset($config['current_page'])
                && !empty($config['current_page'])))
        {
            $this->cursor = $config['current_page'];
        }
        else
        {
            return FALSE;
        }

        if (isset($config['base_url']) && !empty($config['base_url']))
        {
            $this->base_url = $config['base_url'];
        }
        else
        {
            return FALSE;
        }

        if (isset($config['total']) && !empty($config['total']))
        {
            $this->total = $config['total'];
        }
        else
        {
            return FALSE;
        }

        if (isset($config['per_page']) && !empty($config['per_page']))
        {
            $this->per_page = $config['per_page'];
        }

        if (isset($config['range']) && !empty($config['range']))
        {
            $this->range = $config['range'];
        }

        if (isset($config['text_previous']) && !empty($config['text_previous']))
        {
            $this->buttons['previous']['text'] = $config['text_previous'];
        }

        if (isset($config['text_first']) && !empty($config['text_first']))
        {
            $this->buttons['first']['text'] = $config['text_first'];
        }

        if (isset($config['text_last']) && !empty($config['text_last']))
        {
            $this->buttons['last']['text'] = $config['text_last'];
        }

        if (isset($config['text_next']) && !empty($config['text_next']))
        {
            $this->buttons['next']['text'] = $config['text_next'];
        }

        $this->pages_total = ceil($this->total / $this->per_page);
    }

    /**
     * Creates the cursors that will link to previous pages.
     *
     * Also controlling the visibility of first and previous buttons.
     *
     * @param Integer $amount The amount of previous pages
     *
     * @return void
     */
    private function build_previous($amount)
    {
        if ($amount > 0)
        {
            $html = '';
            if (($this->cursor - $amount) > 0)
            {
                $start = $this->cursor - $amount;
            }
            else
            {
                $start = 1;
            }

            $end = $this->cursor - 1;
            for($i = $start; $i <= $end; ++$i)
            {
                $html .= '<a class="paginator_page" href="';
                $html .= $this->base_url . $i . '">' . $i . "</a>\n";
            }

            return $html;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Creates the cursors that will link to next pages.
     *
     * Also controlling the visibility of last and next buttons
     *
     * @param Integer $amount The amount of next pages
     *
     * @return void
     */
    private function build_next($amount)
    {
        if ($amount > 0)
        {
            $html  = '';
            $start = $this->cursor + 1;
            $end   = $this->cursor + $amount;
            for($i = $start; (($i <= $end) && ($i <= $this->pages_total)); ++$i)
            {
                $html .= '<a class="paginator_page" href="';
                $html .= $this->base_url . $i . '">' . $i . "</a>\n";
            }

            return $html;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Build a special pagination button.
     *
     * @param String $type ENUM: previous|next|first|last
     *
     * @return mixed $return The html code if we could generate a button,
     *                       FALSE if an invalid type was passed
     */
    private function build_button($type)
    {
        switch ($type)
        {
            case 'previous':
                $target = $this->cursor - 1;
                break;
            case 'next':
                $target = $this->cursor + 1;
                break;
            case 'first':
                $target = 1;
                break;
            case 'last':
                $target = $this->pages_total;
                break;
            default:
                return FALSE;
        }

        if ($this->buttons[$type]['enabled'])
        {
            // these divs wrap the the test (or image) for the buttons:
            // first, last, previous and second
            $html  = "<div class='paginator_$type'><a href='";
            $html .= $this->base_url . $target . "'>";
            $html .= $this->buttons[$type]['text'] . "</a></div>\n";
        }
        else
        {
            // the same as above but to allow the divs being showed as disabled
            $html  = "<div class='paginator_$type paginator_${type}_disabled'>";
            $html .= $this->buttons[$type]['text'] . "</div>\n";
        }

        return $html;
    }

    /**
     * Builds the Pagination html using the following template.
     *
     * <ul>
     * <li>[<<]   first button (enabled or disabled)</li>
     * <li>[<]    previous button (shown or hidden)</li>
     * <li>[2][3] previous cursors (number depends on $range)</li>
     * <li>4      current cursor (does not link anywhere)</li>
     * <li>[5][6] next cursors (number depends on $range)</li>
     * <li>[>]    next button (shown or hidden)</li>
     * <li>[>>]   last button (enabled or disabled)</li>
     * </ul>
     *
     * @return String
     */
    public function create_links()
    {
        // If base_url is empty it is because the initialize method has
        // not been called
        if(empty($this->base_url))
        {
            return FALSE;
        }

        // current cursor above the limit (pages_total) is not allowed
        if ($this->cursor > $this->pages_total)
        {
            $this->cursor = $this->pages_total;
        }

        // If range is bigger than the amount of previous pages, increase
        // the amount of next pages shown
        if ($this->cursor <= $this->range)
        {
            $nprevious = $this->cursor - 1;
            $nnext     = $this->range + $this->range - $nprevious;
        }

        // If range is bigger than the amount of next pages, check whether
        // the amount of previous pages was already defined and if not,
        // increase the amount of previous pages shown
        if ($this->cursor > $this->pages_total - $this->range)
        {
            $nnext = $this->pages_total - $this->cursor;
            if (!isset($nprevious))
            {
                $nprevious = $this->range + $this->range - $nnext;
            }
        }
        else
        {
            if (!isset($nnext))
            {
                $nnext = $this->range;
            }

            if (!isset($nprevious))
            {
                $nprevious = $this->range;
            }
        }

        if ($this->cursor == 1)
        {
            $this->buttons['first']['enabled']    = FALSE;
            $this->buttons['previous']['enabled'] = FALSE;
        }

        if ($this->cursor == $this->pages_total)
        {
            $this->buttons['next']['enabled'] = FALSE;
            $this->buttons['last']['enabled'] = FALSE;
        }

        $html  = $this->build_button('first');
        $html .= $this->build_button('previous');
        // paginator_numbers class div wraps the cursors shown as numbers.
        // This wrapping div allow us to show the numbers centered in screen
        $html .= "<div class='paginator_numbers'>\n";
        $html .= $this->build_previous($nprevious);
        // using the span we set the style for the current cursor
        $html .= '<span class="paginator_page paginator_page_sel">';
        $html .= $this->cursor . "</span>\n";
        $html .= $this->build_next($nnext);
        $html .= "</div>\n"; // closes <div class='paginator_numbers'>
        $html .= $this->build_button('next');
        $html .= $this->build_button('last');

        return $html;
    }

}

?>