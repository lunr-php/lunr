<?php

/**
 * MySQL canonical query class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     David Mendes <d.mendes@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL;

/**
 * This class returns the Canonicalized query.
 */
class MySQLCanonicalQuery
{

    /**
     * Query to canonicalize.
     * @var string
     */
    private $query;

    /**
     * Canonicalized query.
     * @var string
     */
    private $canonical_query;

    /**
     * List of index ranges to ignore.
     * @var array
     */
    private $ignore_positions;

    /**
     * Constructor.
     *
     * @param string $query Executed query
     */
    public function __construct(string $query)
    {
        $this->query           = $query;
        $this->canonical_query = NULL;
    }

    /**
     * __toString.
     *
     * @return string $returns The executed query canonicalized
     */
    public function __toString(): string
    {
        return $this->get_canonical_query();
    }

    /**
     * Get the executed query canonicalized.
     *
     * @return string $canonical_query The executed query canonicalized
     */
    public function get_canonical_query(): string
    {
        if ($this->canonical_query !== NULL)
        {
            return $this->canonical_query;
        }

        $this->ignore_positions = [];

        $tmp_query = $this->query;

        $tmp_query = $this->replace_between($tmp_query, '#', PHP_EOL, '');
        $tmp_query = $this->replace_between($tmp_query, '--', PHP_EOL, '');

        $tmp_query = $this->remove_eol_blank_spaces($tmp_query);

        $this->add_ignore_positions($this->find_positions($tmp_query, '/*M', '*/'));
        $this->add_ignore_positions($this->find_positions($tmp_query, '/*!', '*/'));
        $this->add_ignore_positions($this->find_positions($tmp_query, '`', '`'));
        $this->add_ignore_positions($this->find_positions($tmp_query, '\\'));

        $tmp_query = $this->replace_between($tmp_query, '/*', '*/', '');
        $tmp_query = $this->replace_between($tmp_query, '"', '"', '"?"', TRUE);
        $tmp_query = $this->replace_between($tmp_query, '\'', '\'', '\'?\'', TRUE);

        $tmp_query = $this->replace_numeric($tmp_query, '?');

        $tmp_query = $this->collapse_multirows($tmp_query);

        $this->canonical_query = $this->remove_eol_blank_spaces($tmp_query);

        return $this->canonical_query;
    }

    /**
     * Replaces text in between two strings
     *
     * @param string  $string        Input string to replace
     * @param string  $from          Input string to start replacing
     * @param string  $to            Input string to end replacing
     * @param string  $replace       Input string to replace with
     * @param boolean $add_to_ignore Input bool to decide if add to ignore list
     *
     * @return string $string The provided string replaced
     */
    private function replace_between(string $string, string $from, string $to, string $replace, bool $add_to_ignore = FALSE): string
    {
        $offset = 0;

        while ($offset < strlen($string))
        {
            $start_pos = strpos($string, $from, $offset);

            if ($start_pos === FALSE)
            {
                break;
            }

            $offset = $this->jump_ignore($start_pos);
            if ($offset > $start_pos)
            {
                continue;
            }

            $end_pos = strpos($string, $to, ($start_pos + 1));

            if ($end_pos === FALSE)
            {
                $end_pos = strlen($string) - 1;
            }

            $len_to_remove = ($end_pos + strlen($to)) - $start_pos;

            $string = substr_replace($string, $replace, $start_pos, $len_to_remove);

            $this->ignore_positions = $this->update_positions($this->ignore_positions, $start_pos, $len_to_remove - strlen($replace));

            if ($add_to_ignore === TRUE)
            {
                $this->add_ignore_positions([[$start_pos, $start_pos + strlen($replace) - 1]]);
            }

            $offset = $start_pos + strlen($replace);
        }

        return $string;
    }

    /**
     * Search for all the index ranges in a string between two strings
     * if $to is empty searches only for $from position
     *
     * @param string      $string Input string to search
     * @param string      $from   Input string to search the start of range
     * @param string|null $to     Input string to search the end of range
     * @param integer     $offset Input int index of where to start the search
     *
     * @return array $positions All ranges between $to and $from,
     *               if can't find $to returns empty,
     *               if can't find $from returns the end of string,
     *               if $to is empty returns all $from positions
     */
    private function find_positions(string $string, string $from, ?string $to = NULL, int $offset = 0): array
    {
        if (empty($from))
        {
            return [];
        }

        $positions = [];
        $end       = strlen($string);
        while ($offset < $end)
        {
            $tmp_position = [strpos($string, $from, $offset), NULL];
            if ($tmp_position[0] === FALSE)
            {
                break;
            }

            $jump = $this->jump_ignore($tmp_position[0]);
            if ($jump > $tmp_position[0])
            {
                $offset = $jump;
                continue;
            }

            $position = $tmp_position;

            if (is_null($to) || $to === '')
            {
                $position[1] = $position[0] + strlen($from) - 1;
                $offset      = $position[1] + 1;
                $positions[] = $position;
                continue;
            }

            $position[1] = strpos($string, $to, ($position[0] + 1));

            if ($position[1] === FALSE)
            {
                $position[1] = strlen($string) - 1;
            }
            else
            {
                $position[1] = $position[1] + strlen($to) - 1;
            }

            $offset      = $position[1] + 1;
            $positions[] = $position;
        }

        return $positions;
    }

    /**
     * Removes blank space and end of line characters from string
     *
     * @param string $string Input string remove
     *
     * @return string $returns The $string without blank spaces and end of line characters
     */
    private function remove_eol_blank_spaces(string $string): string
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }

    /**
     * Add a range of indexes to $ignore_positions
     *
     * @param array $positions Input array with ranges of indexes
     * @return void
     */
    private function add_ignore_positions(array $positions): void
    {
        $this->ignore_positions = array_merge($this->ignore_positions, $positions);
        asort($this->ignore_positions);
        $this->ignore_positions = array_values($this->ignore_positions);
    }

    /**
     * Update all index ranges if start index
     *
     * @param array   $positions Input array with ranges of indexes
     * @param integer $start     Input integer to start the update
     * @param integer $offset    Input integer with the amount to offset positions
     *
     * @return array returns $positions updated
     */
    private function update_positions(array $positions, int $start, int $offset): array
    {
        foreach ($positions as $k => $position)
        {
            $positions[$k][0] = ($position[0] < $start) ? $position[0] : $position[0] - $offset;
            $positions[$k][1] = ($position[1] < $start) ? $position[1] : $position[1] - $offset;
        }

        return $positions;
    }

    /**
     * Get the index position of the next digit from offset
     *
     * @param string  $string Input string where to search for the next index position
     * @param integer $offset Input integer where to start to search
     *
     * @return integer|null return Index of the next digit, NULL if not found
     */
    private function find_digit(string $string, int $offset): ?int
    {
        $end = strlen($string);
        for ($i = $offset; $i < $end; ++$i)
        {
            $jump = $this->jump_ignore($i);
            if ($jump > $i)
            {
                $i = $jump;
                continue;
            }

            if (ctype_digit($string[$i]) && ($i == 0 || (!ctype_alnum(substr($string, $i - 1, 1)) && substr($string, $i - 1, 1) != '_')))
            {
                return $i;
            }
        }

        return NULL;
    }

    /**
     * Replaces numeric value (Integer, Decimal, Hexadecimal, Exponential) with string
     *
     * @param string $string  Input string to replace
     * @param string $replace Input string to replace with
     *
     * @return string returns string with numeric values replaced
     */
    private function replace_numeric(string $string, string $replace): string
    {
        $end = strlen($string);
        for ($i = 0; $i < $end; ++$i)
        {
            $pos = $this->find_digit($string, $i);
            if (!isset($pos))
            {
                break;
            }

            $number_end = $this->is_numeric_value($string, $pos);

            $i = $number_end[1];

            if ($number_end[0] === FALSE)
            {
                continue;
            }

            if ($this->is_negative_number($string, $pos))
            {
                $pos--;
            }

            $replace_size           = strlen($replace);
            $to_replace_length      = $number_end[1] - $pos + 1;
            $string                 = substr_replace($string, $replace, $pos, $to_replace_length);
            $this->ignore_positions = $this->update_positions($this->ignore_positions, $pos, $to_replace_length - $replace_size);

            $i = $pos + $replace_size;
        }

        return $string;
    }

    /**
     * Check if number is a negation
     *
     * @param string  $string Input string to check
     * @param integer $i      Start index of the number position
     *
     * @return boolean returns TRUE if finds the negation character and is not a subtraction, FALSE otherwise
     */
    private function is_negative_number(string $string, int $i): bool
    {
        $is_negative_number = FALSE;
        if ($i > 0 && $string[$i - 1] == '-')
        {
            $i--;
            // Possibly a negative number
            $is_negative_number = TRUE;
            for ($j = $i - 1; $j >= 0; $j--)
            {
                if (!ctype_space($string[$j]))
                {
                    /** If we find a previously converted value, we know that it
                     * is not a negation but a subtraction. */
                    $is_negative_number = ($string[$j] != '?');
                    break;
                }
            }
        }

        return $is_negative_number;
    }

    /**
     * Check if digit is a number and get the position of last number digit
     *
     * @param string  $string Input string to check
     * @param integer $i      Start position of digit index
     *
     * @return array $return the last index of number and is number result
     */
    private function is_numeric_value(string $string, int $i): array
    {
        $allow_hex      = FALSE;
        $is_hexadecimal = (($string[$i] == '0'));

        $i++; //first number we already know is numeric
        $end       = strlen($string);
        $is_number = TRUE;

        while ($i < $end)
        {
            if (!(ctype_digit($string[$i]) || ($allow_hex && ctype_xdigit($string[$i]))))
            {
                if ($is_hexadecimal == TRUE && strtolower($string[$i]) == 'x')
                {
                    $is_hexadecimal = FALSE;
                    $allow_hex      = TRUE;
                }
                elseif (strtolower($string[$i]) == 'e')
                {
                    $next = $i + 1;
                    // Possible scientific notation number
                    if ($next == $end || (!ctype_digit($string[$next]) && $string[$next] != '-'))
                    {
                        $i         = ++$next;
                        $is_number = FALSE;
                        break;
                    }

                    // Skip over the minus if we have one
                    if ($string[$next] == '-')
                    {
                        $i++;
                    }
                }
                elseif ($string[$i] == '.')
                {
                    $next = $i + 1;
                    // Possible decimal number
                    if ($next != $end && !ctype_digit($string[$next]))
                    {
                        /** The fractional part of a decimal is optional in MariaDB. */
                        break;
                    }
                }
                else
                {
                    // If we have a non-text character, we treat it as a number
                    $is_number = !ctype_alpha($string[$i]);
                    break;
                }
            }

            $i++;
        }

        return [$is_number, --$i];
    }

    /**
     * Checks if index is in a position to ignore, and returns next position
     *
     * @param integer $index Input integer to check if is between ranges
     *
     * @return integer returns the position after the range to ignore, if not in range returns the provided index
     */
    private function jump_ignore(int $index): int
    {
        foreach ($this->ignore_positions as $position)
        {
            if ($position[0] <= $index && $position[1] >= $index)
            {
                $index = $position[1] + 1;
            }
        }

        return $index;
    }

    /**
     * Collapses multi-row insert into one
     *
     * @param string $string Input string with canonical query to collapse
     *
     * @return string|null returns the string with canonical_query without multi-row values
     */
    private function collapse_multirows(string $string): ?string
    {
        if (stripos($string, 'INSERT INTO') === FALSE && stripos($string, 'REPLACE INTO') === FALSE)
        {
            return $string;
        }

        $end    = strlen($string);
        $offset = $this->find_positions($string, 'VALUES');

        if (count($offset) === 0)
        {
            return $string;
        }

        $first_row_position = $this->get_between_delimiter($string, '(', ')', $offset[0][1] + 1, [' ']);

        if ($first_row_position === NULL)
        {
            return $string;
        }

        $first_row = substr($string, $first_row_position[0], $first_row_position[1] - $first_row_position[0] + 1);

        $tmp_string = $string;
        $i          = $first_row_position[1] + 1;
        while ($i < $end)
        {
            $next_row_start = $this->find_next($tmp_string, ',', $first_row_position[1] + 1, [' ']);
            if ($next_row_start === NULL)
            {
                break;
            }

            $row_position = $this->get_between_delimiter($tmp_string, '(', ')', $next_row_start + 1, [' ']);
            if ($row_position === NULL)
            {
                return $string;
            }

            $row = substr($tmp_string, $row_position[0], $row_position[1] - $row_position[0] + 1);

            if ($first_row != $row)
            {
                return $string;
            }

            $tmp_string = substr_replace($tmp_string, '', $first_row_position[1] + 1, $row_position[1] - $first_row_position[1]);

            $end = strlen($tmp_string);
            $i   = $first_row_position[1] + 1;
        }

        return $tmp_string;
    }

    /**
     * Finds the next start and end index positions between two delimiters, ignoring delimiters in between
     *
     * @param string  $string    Input string to search
     * @param string  $start_del Input string with start delimiter
     * @param string  $end_del   Input string with end delimiter
     * @param integer $offset    Input int with index to start the search
     * @param array   $ignore    Input array with chars to ignore until start position is found
     *
     * @return array|null returns the range position of the start and end delimiters, if is not found returns null
     */
    private function get_between_delimiter(string $string, string $start_del, string $end_del, int $offset = 0, array $ignore): ?array
    {
        $end                   = strlen($string);
        $delimiter_start_index = NULL;
        $delimiter_end_index   = NULL;
        for ($i = $offset; $i < $end; $i++)
        {
            if ($string[$i] === $start_del)
            {
                $delimiter_start_index = $i;
                break;
            }
            elseif ($string[$i] == in_array($string[$i], $ignore))
            {
                continue;
            }
            elseif ($string[$i] != $start_del)
            {
                return NULL;
            }
        }

        if ($delimiter_start_index === NULL)
        {
            return NULL;
        }

        $count_p = 0;
        for ($i = $delimiter_start_index + 1; $i < $end; $i++)
        {
            if ($string[$i] === $start_del)
            {
                $count_p++;
            }
            elseif ($string[$i] === $end_del && $count_p > 0)
            {
                $count_p--;
            }
            elseif ($string[$i] === $end_del && $count_p === 0)
            {
                $delimiter_end_index = $i;
                break;
            }
        }

        if ($delimiter_end_index === NULL)
        {
            return NULL;
        }

        return [$delimiter_start_index, $delimiter_end_index];
    }

    /**
     * Finds the next index position of a char
     *
     * @param string     $string      Input string to search
     * @param string     $char        Input string with character to find
     * @param integer    $offset      Input string start position
     * @param array|null $ignore_char Input array with characters to ignore, if null ignores all chars
     *
     * @return integer|null returns the index position of the value found, if not found returns null
     */
    private function find_next(string $string, string $char, int $offset, ?array $ignore_char = NULL): ?int
    {
        $end = strlen($string);

        while ($offset < $end)
        {
            $jump = $this->jump_ignore($offset);
            if ($jump > $offset)
            {
                $offset = $jump;
                continue;
            }

            if ($string[$offset] === $char)
            {
                return $offset;
            }

            if ($ignore_char !== NULL && $string[$offset] == in_array($string[$offset], $ignore_char))
            {
                $offset++;
                continue;
            }

            if ($string[$offset] !== $char && $ignore_char !== NULL)
            {
                break;
            }

            $offset++;
        }

        return NULL;
    }

}
