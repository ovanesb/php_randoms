<?php

/**
 * Description of DB
 *
 * @author ovanes
 */
abstract class DB implements DBInterface{
    
    /**
     *
     * @var object
     */
    public $driver;

    public function __construct() {
        $this->driver = $this->getConnection();
    }

    private function getConnection() {
        /**
         * In order to load file it needs full server path to it.
         */
        return new SQLite3('/var/www/Bank/db/Bank.db');
    }

    /**
     * 
     * @param string $table
     * @param array $input
     */
    public function insert($table, $input){
        $this->driver->query( "INSERT INTO {$table} (" . implode(', ' , array_keys($input)) . ") VALUES ('" . implode("', '", $input) . "');" );
    }
    
    public function select($table, $where = null) {
        
        if( $where !== null ){
            return $this->driver->query("SELECT * FROM {$table} WHERE " . implode(', ' , array_keys($where)). " = '" . implode("', '", $where) . "';");
        }
        
    }
    
    public function selectOneRow($table, $column, $where){
        return $this->driver->querySingle("SELECT {$column} FROM {$table} WHERE " . implode(', ' , array_keys($where)). " = '" . implode("', '", $where) . "';");
    }

    public function update($table, $set, $where) {
        
        /**
         * Prepare key value 
         * Example: column = value, ... , n
         */
        $setForUpdate = '';
        foreach($set as $key => $val){
            $setForUpdate .= "{$key} = '{$val}',"; 
        }
        
        /**
         * Remove last comma from the string.
         */
        $setString = rtrim($setForUpdate,',');

        /**
         * Do update
         */
        $this->driver->query("UPDATE $table SET {$setString} WHERE " . implode(', ' , array_keys($where)). " = '" . implode("', '", $where) . "';");
    }
    
    public function queryRow($query){
        return $this->driver->query($query);
    }
    
}
