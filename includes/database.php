<?php require_once 'config.php'; ?>
<?php

/*
 * Connect TO MYSQL Database
 * @author : Salameh Yasin <talkphp.sam@gmail.com>
 */

class database {

    private $connection;
    private $databaseName;

    public function __construct() {
        $this->openConnection();
    }

    private function openConnection() {
        $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
        if (!$this->connection) {
            die(mysql_error());
        } else {
            $this->databaseName = mysql_select_db(DB_NAME);
            if (!$this->databaseName) {
                die(mysql_error());
            }
        }
    }

    public function query($sql) {
        $query = mysql_query($sql);
        return $this->confirmQuery($query);
    }

    public function confirmQuery($query) {
        if (isset($query)) {
            return $query;
        } else {
            return false;
        }
    }

    public function fetchArray($result) {
        $rows = array();
        while ($querySet = mysql_fetch_array($result)) {
            $rows[] = $querySet;
        }
        if (isset($rows) && !empty($rows)) {
            return $rows;
        } else {
            return FALSE;
        }
    }

    public function lastId() {
        return mysql_insert_id();
    }
    public function affectedRows(){
        return mysql_affected_rows();
    }
    
    public function filter($value = ''){
        echo mysql_real_escape_string($value);die;
        return mysql_real_escape_string($value);
    }

}

?>
