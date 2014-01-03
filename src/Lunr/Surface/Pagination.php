<?php

/**
 * This file contains the Pagination class. Pagination takes an
 * array of data items, splits them among multiple HTML pages
 * and makes them accessible via a navigation interface.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Surface
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2010-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Surface;

/**
 * Pagination class
 *
 * @category   Libraries
 * @package    Surface
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
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
     *
     * @param RequestInterface $request reference to the request class
     */
    public function __construct($request)
    {
        // Default values
        $this->per_page    = 25;
        $this->range       = 2;
        $this->total       = -1;
        $this->pages_total = 0;
        $this->cursor      = 1;

        $params = $request->params;
        if (!empty($params))
        {
            $cursor = array_pop($params);
            //Extract the page cursor from the parameters array
            if (is_numeric($cursor))
            {
                $this->cursor = (int) $cursor;
            }
            else
            {
                $params[] = $cursor;
            }
        }

        //Construct base url
        $this->base_url  = $request->base_url . '/' . $request->controller . '/' . $request->method . '/';
        $this->base_url .= implode('/', $params) . '/';

        $this->buttons = array();

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
     * Define the total number of items to be paginated.
     *
     * @param Integer $nritems the actual number of items
     *
     * @return Pagination $self self reference
     */
    public function set_total_items($nritems)
    {
        if (is_int($nritems) && ($nritems > 0))
        {
            $this->total = $nritems;
        }

        return $this;
    }

    /**
     * Define the base url of the pagination links.
     *
     * @param String $url the actual base url
     *
     * @return Pagination $self self reference
     */
    public function set_base_url($url)
    {
        if (is_string($url))
        {
            $this->base_url = $url;
        }

        return $this;
    }

    /**
     * Assign labels to the first, last, next & previous buttons.
     *
     * @param String $key   can be one of the following:
     *                      'first', 'last', 'next', 'previous'
     * @param String $label the text to be put at the corresponding button
     *
     * @return Pagination $self self reference
     */
    public function set_button_label($key, $label)
    {
        if (array_key_exists($key, $this->buttons))
        {
            $this->buttons[$key]['text'] = $label;
        }

        return $this;
    }

    /**
     * Define the number of pages displayed before and after the current one.
     *
     * @param Integer $range the actual range
     *
     * @return Pagination $self self reference
     */
    public function set_range($range)
    {
        if (is_int($range) && ($range > 0))
        {
            $this->range = $range;
        }

        return $this;
    }

    /**
     * Define the number of items per page.
     *
     * @param Integer $per_page the actual number of items per page
     *
     * @return Pagination $self self reference
     */
    public function set_items_per_page($per_page)
    {
        if (is_int($per_page) && ($per_page > 0))
        {
            $this->per_page = $per_page;
        }

        return $this;
    }

    /**
     * Creates the cursors that will link to next/previous pages.
     *
     * @param Integer $amount   The amount of next pages
     * @param Boolean $previous Whether to build the previous or next pages
     *
     * @return String $html Constructed HTML code or empty string
     */
    private function build_page_buttons($amount, $previous = TRUE)
    {
        if ($amount <= 0)
        {
            return '';
        }

        $html = '';

        $start = $previous ? $this->cursor - $amount : $this->cursor + 1;
        $end   = $previous ? $this->cursor - 1 : $this->cursor + $amount;

        for ($i = $start; $i <= $end; ++$i)
        {
            $html .= '<a class="lunr_paginator_page" href="';
            $html .= $this->base_url . $i . '">' . $i . "</a>\n";
        }

        return $html;
    }

    /**
     * Build a special pagination button.
     *
     * @param String  $type   ENUM: previous|next|first|last
     * @param Integer $target The page index to target
     *
     * @return mixed $return The html code if we could generate a button,
     *                       an empty string if an invalid type was passed
     */
    private function build_button($type, $target)
    {
        if ($this->buttons[$type]['enabled'])
        {
            // these divs wrap the test (or image) for the buttons:
            // first, last, previous and second
            $html  = "<div class='lunr_paginator_$type'><a href='";
            $html .= $this->base_url . $target . "'>";
            $html .= $this->buttons[$type]['text'] . "</a></div>\n";
        }
        else
        {
            // the same as above but to allow the divs being showed as disabled
            $html  = "<div class='lunr_paginator_$type lunr_paginator_${type}_disabled'>";
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
        // If the total number of items has its default value,
        // then the set_total_items has not been called and the pagination cannot be built
        if($this->total == -1)
        {
            return FALSE;
        }

        //calculate the total number of pages
        $this->pages_total = ceil($this->total / $this->per_page);

        // current cursor above the limit (pages_total) is not allowed
        if ($this->cursor > $this->pages_total)
        {
            $this->cursor = $this->pages_total;
        }

        $nprevious = min($this->range, $this->cursor - 1);
        $nnext     = max($this->range, $this->range + $this->range - $nprevious);

        if (($this->cursor + $nnext) > $this->pages_total)
        {
            $factor = ($this->cursor + $nnext) - $this->pages_total;
            $nnext -= $factor;

            $reach = $this->cursor - $nprevious - $factor;

            $nprevious = ($reach > 0) ? $nprevious + $factor : $nprevious + $factor - $reach - 1;
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

        $html  = $this->build_button('first', 1);
        $html .= $this->build_button('previous', $this->cursor - 1);
        // paginator_numbers class div wraps the cursors shown as numbers.
        // This wrapping div allow us to show the numbers centered in screen
        $html .= "<div class='lunr_paginator_numbers'>\n";
        $html .= $this->build_page_buttons($nprevious, TRUE);
        // using the span we set the style for the current cursor
        $html .= '<span class="lunr_paginator_page lunr_paginator_page_sel">';
        $html .= $this->cursor . "</span>\n";
        $html .= $this->build_page_buttons($nnext, FALSE);
        $html .= "</div>\n"; // closes <div class='lunr_paginator_numbers'>
        $html .= $this->build_button('next', $this->cursor + 1);
        $html .= $this->build_button('last', $this->pages_total);

        return $html;
    }

}

?>
