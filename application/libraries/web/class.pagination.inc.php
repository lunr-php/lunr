<?php

/**
 * Pagination class
 * @author M2Mobi, Javier Negre, Heinz Wiesinger
 */
class Pagination{

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
     * Constructor
     */
    public function __construct()
    {
        // Default values
        $this->per_page = 25;
        $this->range    =  2;

        $this->buttons = array();
        $this->buttons['first'] = array();
        $this->buttons['first']['text'] = '&#8810;';
        $this->buttons['first']['enabled'] = TRUE;

        $this->buttons['previous'] = array();
        $this->buttons['previous']['text'] = '&lt;';
        $this->buttons['previous']['enabled'] = TRUE;

        $this->buttons['next'] = array();
        $this->buttons['next']['text'] = '&gt;';
        $this->buttons['next']['enabled'] = TRUE;

        $this->buttons['last'] = array();
        $this->buttons['last']['text'] = '&#8811;';
        $this->buttons['last']['enabled'] = TRUE;

    }

    /**
     * Destructor
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
     * Initializes the Pagination, calculates number of pages and builds the Pagination
     * @param config Array
     * @return void
     * The array keys and values data types are the following:
     *   -) 'current_page', Integer (Mandatory)
     *   -) 'base_url', String (Mandatory)
     *   -) 'total', Integer (Mandatory, total number of items queried)
     *   -) 'per_page', Integer (Optional, items shown per page, set to 25 by default)
     *   -) 'range', Integer (Optional, cursors lesser and bigger shown before and after the
     *                        current cursor, set to 2 by default)
     *   -) 'text_previous', String (Optional, text shown in previous button, set to "&lt;" by default)
     *   -) 'text_separator', String (Optional, text shown in separators, set to "..." by default)
     *   -) 'text_next', String (Optional, text shown in next button, set to "&gt;" by default)
     */
    public function initialize($config)
    {
        // empty(0) is true and be want to avoid it, so we check if cursor is 0
        if ($config['current_page'] == 0 || (isset($config['current_page']) && !empty($config['current_page'])))
        {
            $this->cursor = $config['current_page'];
        }
        else
        {
            return FALSE;
        }

        if (isset($config['base_url']) and !empty($config['base_url']))
        {
            $this->base_url = $config['base_url'];
        }
        else
        {
            return FALSE;
        }

        if (isset($config['total']) and !empty($config['total']))
        {
            $this->total = $config['total'];
        }
        else
        {
            return FALSE;
        }

        if (isset($config['per_page']) and !empty($config['per_page']))
        {
            $this->per_page = $config['per_page'];
        }

        if (isset($config['range']) and !empty($config['range']))
        {
            $this->range = $config['range'];
        }

        if (isset($config['text_previous']) and !empty($config['text_previous']))
        {
            $this->buttons['previous']['text'] = $config['text_previous'];
        }

        if (isset($config['text_first']) and !empty($config['text_first']))
        {
            $this->buttons['first']['text'] = $config['text_first'];
        }

        if (isset($config['text_last']) and !empty($config['text_last']))
        {
            $this->buttons['last']['text'] = $config['text_last'];
        }

        if (isset($config['text_next']) and !empty($config['text_next']))
        {
            $this->buttons['next']['text'] = $config['text_next'];
        }

        $this->pages_total = ceil($this->total / $this->per_page);
    }

    /**
     * Creates the cursors that will link to previous pages, also controlling the visibility of first
     * and previous buttons
     * @return void
     */
    private function build_previous($amount)
    {
        if (($amount < $this->cursor) && ($amount > 0))
        {
            $html = "";
            for($i = ($this->cursor - $amount) ; $i < $this->cursor ; ++$i)
            {
                $html .= '<a class="paginator_page" href="' . $this->base_url . $i . '">' . ($i) . '</a>' . "\n";
            }
            return $html;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Creates the cursors that will link to next pages, also controlling the visibility of last
     * and next buttons
     * @return void
     */
    private function build_next($amount)
    {
        if (($amount < $this->pages_total) && ($amount > 0))
        {
            $html = "";
            for($i = $this->cursor + 1 ; $i <= $this->cursor + $amount ; ++$i)
            {
                $html .= '<a class="paginator_page" href="' . $this->base_url . $i . '">' . ($i) . "</a>\n";
            }
            return $html;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Build a special pagination button
     * @param String $type ENUM: previous|next|first|last
     * @return mixed $return The html code if we could generate a button, FALSE if an invalid type was passed
     */
    private function build_button($type)
    {
        switch ($type)
        {
            case "previous":
                $target = $this->cursor -1;
                break;
            case "next":
                $target = $this->cursor +1;
                break;
            case "first":
                $target = 1;
                break;
            case "last":
                $target = $this->pages_total;
                break;
            default:
                return FALSE;
        }

        if ($this->buttons[$type]['enabled'])
        {
            // these divs wrap the the test (or image) for the buttons: first, last, previous and second
            $html = "<div class='paginator_$type'><a href='" . $this->base_url . $target . "'>" . $this->buttons[$type]['text'] . "</a></div>\n";
        }
        else
        {
            // the same as above but to allow the divs being showed as disabled
            $html = "<div class='paginator_$type paginator_${type}_disabled'>" . $this->buttons[$type]['text'] . "</div>\n";
        }

        return $html;
    }

    /**
     * Builds the Pagination html using the following template:
     *
     *    +------------------------------------------ first button (enabled or disabled)
     *    |    +------------------------------------- previous button (shown or hidden)
     *    |    |   +--+------------------------------ previous cursors (number depends on $range)
     *    |    |   |  |   +-------------------------- current cursor (does not link anywhere)
     *    |    |   |  |   |   +--+------------------- next cursors (number depends on $range)
     *    |    |   |  |   |   |  |   +--------------- next button (shown or hidden)
     *    |    |   |  |   |   |  |   |   +----------- last button (enabled or disabled)
     *    v    v   v  v   v   v  v   v   v
     *   [<<] [<] [2][3]  4  [5][6] [>] [>>]
     * @return String
     */
    public function create_links()
    {
        // If base_url is empty it is because the initialize method has not been called
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
            $nnext = $this->range + $this->range - $nprevious;
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
            $this->buttons['first']['enabled'] = FALSE;
            $this->buttons['previous']['enabled'] = FALSE;
        }
        if ($this->cursor == $this->pages_total)
        {
            $this->buttons['next']['enabled'] = FALSE;
            $this->buttons['last']['enabled'] = FALSE;
        }

        $html  = $this->build_button("first");
        $html .= $this->build_button("previous");
        // paginator_numbers class div wraps the cursors shown as numbers. This wrapping div allow us to show
        // the numbers centered in screen
        $html .= "<div class='paginator_numbers'>\n";
        $html .= $this->build_previous($nprevious);
        // using the span we set the style for the current cursor
        $html .= '<span class="paginator_page paginator_page_sel">' . ($this->cursor) . "</span>\n";
        $html .= $this->build_next($nnext);
        $html .= "</div>\n"; // closes <div class='paginator_numbers'>
        $html .= $this->build_button("next");
        $html .= $this->build_button("last");

        return $html;
    }
}

?>