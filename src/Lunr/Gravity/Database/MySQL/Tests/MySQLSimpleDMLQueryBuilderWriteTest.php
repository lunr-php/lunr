<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderWriteTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

/**
 * This class contains update/delete/insert tests for the MySQLSimpleDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder
 */
class MySQLSimpleDMLQueryBuilderWriteTest extends MySQLSimpleDMLQueryBuilderTest
{

    /**
     * Test get_insert_query() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertQuery(): void
    {
        $this->builder->expects($this->once())
                      ->method('get_insert_query')
                      ->willReturn('');

        $this->class->get_insert_query();
    }

    /**
     * Test get_replace_query() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceQuery(): void
    {
        $this->builder->expects($this->once())
                      ->method('get_replace_query')
                      ->willReturn('');

        $this->class->get_replace_query();
    }

    /**
     * Test get_delete_query() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::get_delete_query
     */
    public function testGetDeleteQuery(): void
    {
        $this->builder->expects($this->once())
                      ->method('get_delete_query')
                      ->willReturn('');

        $this->class->get_delete_query();
    }

    /**
     * Test get_update_query() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQuery(): void
    {
        $this->builder->expects($this->once())
                      ->method('get_update_query')
                      ->willReturn('');

        $this->class->get_update_query();
    }

    /**
     * Test insert_mode() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::insert_mode
     */
    public function testInsertMode(): void
    {
        $this->builder->expects($this->once())
                      ->method('insert_mode')
                      ->with('DELAYED')
                      ->will($this->returnSelf());

        $this->class->insert_mode('DELAYED');
    }

    /**
     * Test replace_mode() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::replace_mode
     */
    public function testReplaceMode(): void
    {
        $this->builder->expects($this->once())
                      ->method('replace_mode')
                      ->with('LOW_PRIORITY')
                      ->will($this->returnSelf());

        $this->class->replace_mode('LOW_PRIORITY');
    }

    /**
     * Test update_mode() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::update_mode
     */
    public function testUpdateMode()
    {
        $this->builder->expects($this->once())
                      ->method('update_mode')
                      ->with('IGNORE')
                      ->will($this->returnSelf());

        $this->class->update_mode('IGNORE');
    }

    /**
     * Test delete_mode() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::delete_mode
     */
    public function testDeleteMode(): void
    {
        $this->builder->expects($this->once())
                      ->method('delete_mode')
                      ->with('QUICK')
                      ->will($this->returnSelf());

        $this->class->delete_mode('QUICK');
    }

    /**
     * Test into().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::into
     */
    public function testInto(): void
    {
        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('table'))
                      ->will($this->returnValue('`table`'));

        $this->builder->expects($this->once())
                      ->method('into')
                      ->with($this->equalTo('`table`'))
                      ->will($this->returnSelf());

        $this->class->into('table');
    }

    /**
     * Test column_names() with a single column.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::column_names
     */
    public function testColumnNamesWithOneColumn(): void
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('col'))
                      ->will($this->returnValue('`col`'));

        $this->builder->expects($this->once())
                      ->method('column_names')
                      ->with($this->equalTo(['`col`']))
                      ->will($this->returnSelf());

        $this->class->column_names([ 'col' ]);
    }

    /**
     * Test column_names() with multiple columns.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::column_names
     */
    public function testColumnNamesWithMultipleColumns(): void
    {
        $this->escaper->expects($this->exactly(2))
             ->method('column')
             ->will($this->returnValueMap([
                 ['col1', '', '`col1`'],
                 ['col2', '', '`col2`'],
             ]));

        $this->builder->expects($this->once())
                      ->method('column_names')
                      ->with($this->equalTo(['`col1`', '`col2`']))
                      ->will($this->returnSelf());

        $this->class->column_names([ 'col1', 'col2' ]);
    }

    /**
     * Test update() with one table to update.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::update
     */
    public function testUpdateWithOneTable(): void
    {
        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('table'))
                      ->will($this->returnValue('`table`'));

        $this->builder->expects($this->once())
                      ->method('update')
                      ->with($this->equalTo('`table`'))
                      ->will($this->returnSelf());

        $this->class->update('table');
    }

    /**
     * Test update() with multiple tables to update.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::update
     */
    public function testUpdateWithMultipleTables(): void
    {
        $this->escaper->expects($this->exactly(2))
                      ->method('table')
                      ->will($this->returnValue('`table`'));

        $this->builder->expects($this->once())
                      ->method('update')
                      ->with($this->equalTo('`table`, `table`'))
                      ->will($this->returnSelf());

        $this->class->update('table, table');
    }

    /**
     * Test delete() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::delete
     */
    public function testDelete(): void
    {
        $this->builder->expects($this->once())
                      ->method('delete')
                      ->with('')
                      ->will($this->returnSelf());

        $this->class->delete('');
    }

    /**
     * Test SELECT statements in INSERT INTO statements
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::select_statement
     */
    public function testSelectStatementInInto(): void
    {
        $query = 'SELECT * from `test`';
        $this->builder->expects($this->once())
                      ->method('select_statement')
                      ->with($query)
                      ->will($this->returnSelf());

        $this->class->select_statement($query);
    }

    /**
     * Test lock_mode() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::lock_mode
     */
    public function testLockMode(): void
    {
        $this->builder->expects($this->once())
                      ->method('lock_mode')
                      ->with('')
                      ->will($this->returnSelf());

        $this->class->lock_mode('');
    }

    /**
     * Test values() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::values
     */
    public function testValues(): void
    {
        $this->builder->expects($this->once())
                      ->method('values')
                      ->with('')
                      ->will($this->returnSelf());

        $this->class->values('');
    }

    /**
     * Test set() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::set
     */
    public function testSetClause(): void
    {
        $this->builder->expects($this->once())
                      ->method('set')
                      ->with('')
                      ->will($this->returnSelf());

        $this->class->set('');
    }

    /**
     * Test with() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::with
     */
    public function testWith(): void
    {
        $this->builder->expects($this->once())
                      ->method('with')
                      ->with('alias', 'query')
                      ->will($this->returnSelf());

        $this->class->with('alias', 'query');
    }

    /**
     * Test with_recursive() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::with_recursive
     */
    public function testWithRecursive(): void
    {
        $this->builder->expects($this->once())
                      ->method('with_recursive')
                      ->with('alias', 'anchor_query', 'recursive_query')
                      ->will($this->returnSelf());

        $this->class->with_recursive('alias', 'anchor_query', 'recursive_query');
    }

    /**
     * Test on_duplicate_key_update() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_duplicate_key_update
     */
    public function testOnDuplicateKeyUpdate()
    {
        $this->builder->expects($this->once())
                      ->method('on_duplicate_key_update')
                      ->with('col=col+1')
                      ->will($this->returnSelf());

        $this->class->on_duplicate_key_update('col=col+1');
    }

}

?>
