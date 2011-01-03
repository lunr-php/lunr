<?php

# Copyright 2009-2010 Heinz Wiesinger, Amsterdam, The Netherlands
# Copyright 2010 M2Mobi BV, Amsterdam, The Netherlands
# All rights reserved.
#
# Redistribution and use of this script, with or without modification, is
# permitted provided that the following conditions are met:
#
# 1. Redistributions of this script must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR ''AS IS'' AND ANY EXPRESS OR IMPLIED
# WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
# MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO
# EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
# SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
# PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
# OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
# WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
# OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
# ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

class Query
{

    /**
     * SQL Query Result
     * @var Mixed
     */
    private $query;

    /**
     * Resource handler for the (established) database connection
     * @var Resource
     */
    private $res;

    /**
     * Constructor
     * @param Mixed $query The Query result
     * @param Resource $res Resource handler for the db connection
     */
    public function __construct($query, $res)
    {
        $this->query = $query;
        $this->res = $res;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        unset($this->query);
        unset($this->res);
    }

    /**
     * Returns the number of affected rows
     * @return Integer number of affected rows
     */
    public function affected_rows()
    {
        return mysqli_affected_rows($this->res);
    }

    /**
     * Returns the number of result rows
     * @return Integer number of result rows
     */
    public function num_rows()
    {
        return mysqli_num_rows($this->query);
    }

    /**
     * Return an array of results
     * @return Array Array of Results
     */
    public function result_array()
    {
        $output = array();
        while ($row = mysqli_fetch_assoc($this->query))
        {
            $output[] = $row;
        }
        return $output;
    }

    /**
     * Return the first row of results
     * @return Array One data row
     */
    public function result_row()
    {
        $output = mysqli_fetch_assoc($this->query);
        return $output;
    }

    /**
     * Return one field for the first row
     * @param String $col The field to return
     * @return mixed Field value
     */
    public function field($col)
    {
        $line = mysqli_fetch_assoc($this->query);
        return $line[$col];
    }

    /**
     * Return a column of results
     * @param String $col The column to return
     * @return Array Query Results
     */
    public function col($col)
    {
        $output = array();
        while ($row = mysqli_fetch_assoc($this->query))
        {
            $output[] = $row[$col];
        }
        return $output;
    }
}

?>