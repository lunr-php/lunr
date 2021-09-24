<?php

/**
 * This file contains the MySQLConnectionEscapeTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLCanonicalQuery;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains unit tests for MySQLCanonicalQuery.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLCanonicalQuery
 */
class MySQLCanonicalQueryTest extends LunrBaseTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
         $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLCanonicalQuery');
         $this->class      = new MySQLCanonicalQuery('');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function findPositionsDataProvider(): array
    {
        $data_provider                               = [];
        $data_provider['first argument not string']  = [[['013456789013456789','23','56'],[]], []];
        $data_provider['second argument not string'] = [[['012346789012346789','23','56'],[]], [[2,17]]];
        $data_provider['both arguments string']      = [[['01234567890123456789','23','56'],[]], [[2,6],[12,16]]];
        $data_provider['both arguments not string']  = [[['01234567890123456789','bb','cc'],[]], []];
        $data_provider['no second argument']         = [[['01234567890123456789','56',''],[]], [[5,6],[15,16]]];
        $data_provider['no first argument']          = [[['01234567890123456789','','56'],[]], []];
        $data_provider['single no second arg']       = [[['01234567890123456789','5',''],[]], [[5,5],[15,15]]];
        $data_provider['ignore positions']           = [[['01234567890123456789','23','56'],[[1,8]]], [[12,16]]];

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function removeEolBlankSpacesDataProvider(): array
    {
        $data_provider   = [];
        $data_provider[] = ['  SELECT     *   FROM `table`   ','SELECT * FROM `table`'];
        $data_provider[] = ["SELECT * \nFROM `table`",'SELECT * FROM `table`'];
        $data_provider[] = ["SELECT * \r\nFROM `table`",'SELECT * FROM `table`'];
        $data_provider[] = ["SELECT * \rFROM `table`",'SELECT * FROM `table`'];

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function isNumericValueDataProvider(): array
    {
        $data_provider   = [];
        $data_provider[] = [['value=234567 AND',6],[TRUE,11]];
        $data_provider[] = [['value=0x47 AND',6],[TRUE,9]];
        $data_provider[] = [['value=1.245 AND',6],[TRUE,10]];
        $data_provider[] = [['value=3.82384E-11 AND',6],[TRUE,16]];

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function updatePositionsDataProvider(): array
    {
        $data_provider   = [];
        $data_provider[] = [[[[3,10],[25,30],[40,50]],15,5],[[3,10],[20,25],[35,45]]];

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function findDigitDataProvider(): array
    {
        $data_provider   = [];
        $data_provider[] = [[['SELECT * FROM `table1` WHERE `value1`="teste" AND `value2`=12', 22],[[29,36],[50,57]]],59];
        $data_provider[] = [[['SELECT * FROM `table1` WHERE `value1`="teste" AND `value2`="A"', 22],[[29,36],[50,57]]],NULL];

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function jumpIgnoreDataProvider(): array
    {
        $data_provider   = [];
        $data_provider[] = [[0,[[0,10],[10,100],[102,110]]], 101];

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function isNegativeNumberDataProvider(): array
    {
        $data_provider   = [];
        $data_provider[] = [['value=123',6], FALSE];
        $data_provider[] = [['value=-123',7], TRUE];
        $data_provider[] = [['value=?-123',8], FALSE];

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function replaceNumericDataProvider(): array
    {
        $data_provider   = [];
        $data_provider[] = [[['value=12 and','?'],NULL],'value=? and'];
        $data_provider[] = [[['value=0x24 and','?'],NULL],'value=? and'];
        $data_provider[] = [[['value=-12 and','?'],NULL],'value=? and'];
        $data_provider[] = [[['value=1.24 and','?'],NULL],'value=? and'];
        $data_provider[] = [[['value=-1.24 and','?'],NULL],'value=? and'];
        $data_provider[] = [[['value=3.8E-11 and','?'],NULL],'value=? and'];
        $data_provider[] = [[['value1=123456 and value2=123456 /*! 123 */','?'],[[32,41]]],'value1=? and value2=? /*! 123 */'];

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function replaceBetweenDataProvider(): array
    {
        $data_provider                       = [];
        $data_provider['replace jump'][0]    = [['SELECT * FROM value1="ignore" AND value2="B"', '"', '"', '"?"',TRUE],[[21,28]]];
        $data_provider['replace jump'][1]    = 'SELECT * FROM value1="ignore" AND value2="?"';
        $data_provider['replace no jump'][0] = [['SELECT * FROM value1="ignore" AND value2="B"', '"', '"', '"?"',TRUE],NULL];
        $data_provider['replace no jump'][1] = 'SELECT * FROM value1="?" AND value2="?"';

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function canonicalQueryDataProvider(): array
    {
        $path = TEST_STATICS . '/Gravity/Database/MySQL/';

        $data_provider['select']                            = [$path . 'input_select.sql', $path . 'output_select.sql'];
        $data_provider['update']                            = [$path . 'input_update.sql', $path . 'output_update.sql'];
        $data_provider['create']                            = [$path . 'input_create.sql', $path . 'output_create.sql'];
        $data_provider['insert single row']                 = [$path . 'input_insert_single_row.sql', $path . 'output_insert_single_row.sql'];
        $data_provider['insert multi-rows']                 = [$path . 'input_insert_multi_rows.sql', $path . 'output_insert_multi_rows.sql'];
        $data_provider['insert different rows']             = [$path . 'input_insert_different_rows.sql', $path . 'output_insert_different_rows.sql'];
        $data_provider['insert no rows']                    = [$path . 'input_insert_no_rows.sql', $path . 'output_insert_no_rows.sql'];
        $data_provider['insert value or null multi-rows']   = [$path . 'input_insert_value_or_null_multirows.sql', $path . 'output_insert_value_or_null_multirows.sql'];
        $data_provider['insert null diff. case multi-rows'] = [$path . 'input_insert_null_diff_case_multi_rows.sql', $path . 'output_insert_null_diff_case_multi_rows.sql'];
        $data_provider['replace single row']                = [$path . 'input_replace_single_row.sql', $path . 'output_replace_single_row.sql'];
        $data_provider['replace multi-rows']                = [$path . 'input_replace_multi_rows.sql', $path . 'output_replace_multi_rows.sql'];
        $data_provider['upserts single row']                = [$path . 'input_upserts_single_row.sql', $path . 'output_upserts_single_row.sql'];
        $data_provider['upserts multi-rows']                = [$path . 'input_upserts_multi_rows.sql', $path . 'output_upserts_multi_rows.sql'];
        $data_provider['upserts function multi-rows']       = [$path . 'input_upserts_function_multi_rows.sql', $path . 'output_upserts_function_multi_rows.sql'];
        $data_provider['maxscalehints']                     = [$path . 'input_maxscalehints.sql', $path . 'output_maxscalehints.sql'];
        $data_provider['cte']                               = [$path . 'input_cte.sql', $path . 'output_cte.sql'];
        $data_provider['unix_lf']                           = [$path . 'input_unix_lf.sql', $path . 'output_unix_lf.sql'];
        $data_provider['win_crlf']                          = [$path . 'input_win_crlf.sql', $path . 'output_win_crlf.sql'];
        $data_provider['mac_cr']                            = [$path . 'input_mac_cr.sql', $path . 'output_mac_cr.sql'];

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function findNextDataProvider(): array
    {
        $data_provider                      = [];
        $data_provider['find']              = [[['VALUES (?) , (?)',',',4,NULL],[]],11];
        $data_provider['find ignore char']  = [[[' ,(?),(?)',',',0,[' ']],[]],1];
        $data_provider['found first index'] = [[[',(?),(?)',',',0,[' ']],[]],0];
        $data_provider['offset']            = [[[',(?) ,(?)',',',4,[' ']],[]],5];
        $data_provider['find not ignore']   = [[['VALUES (?) , (?)',',',4,[' ']],[]],NULL];
        $data_provider['not found']         = [[['(?,?) ON ',',',4,NULL],[]],NULL];

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function getBetweenDelimiterDataProvider(): array
    {
        $data_provider                      = [];
        $data_provider['simple']            = [[' (?,?,"?") , (?,?,"?") ','(',')',0,[' ']],[1,9]];
        $data_provider['offset']            = [['values (?,?,"?") , (?,?,"?") ','(',')',18,[' ']],[19,27]];
        $data_provider['delimiters inside'] = [['values (COALESCE(?,"?"),?,"?") ','(',')',6,[' ']],[7,29]];
        $data_provider['not found']         = [['values (?,?,"?") , (?,?,"?") ','{','}',6,[' ']],NULL];

        return $data_provider;
    }

    /**
     * Unit Test Data Provider.
     *
     * @return array $data_provider Array of data values.
     */
    public function collapseMultiRowInsertsDataProvider(): array
    {
        $path = TEST_STATICS . '/Gravity/Database/MySQL/';

        $data_provider['insert single row']    = [$path . 'input_collapse_insert_single_row.sql', $path . 'output_collapse_insert_single_row.sql'];
        $data_provider['insert multi-rows']    = [$path . 'input_collapse_insert_multi_rows.sql', $path . 'output_collapse_insert_multi_rows.sql'];
        $data_provider['insert no rows']       = [$path . 'input_collapse_insert_no_rows.sql', $path . 'output_collapse_insert_no_rows.sql'];
        $data_provider['insert different row'] = [$path . 'input_collapse_insert_different_row.sql', $path . 'output_collapse_insert_different_row.sql'];
        $data_provider['insert function']      = [$path . 'input_collapse_insert_function_multi_rows.sql', $path . 'output_collapse_insert_function_multi_rows.sql'];
        $data_provider['replace']              = [$path . 'input_collapse_replace_multi_rows.sql', $path . 'output_collapse_replace_multi_rows.sql'];
        $data_provider['upserts single row']   = [$path . 'input_collapse_upserts_single_row.sql', $path . 'output_collapse_upserts_single_row.sql'];
        $data_provider['upserts multi-rows']   = [$path . 'input_collapse_upserts_multi_rows.sql', $path . 'output_collapse_upserts_multi_rows.sql'];
        $data_provider['upserts function']     = [$path . 'input_collapse_upserts_function.sql', $path . 'output_collapse_upserts_function.sql'];
        $data_provider['select']               = [$path . 'input_collapse_select.sql', $path . 'output_collapse_select.sql'];

        return $data_provider;
    }

}
