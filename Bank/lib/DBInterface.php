<?php

/**
 *
 * @author ovanes
 */
interface DBInterface {
    
    public function select($table, $where);
    public function selectOneRow($table, $column, $where);
    public function insert($table, $input);
    public function update($table, $set, $where);
    public function queryRow($query);
    
}
