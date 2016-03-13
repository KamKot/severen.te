<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.02.16
 * Time: 21:37
 */
class Connect_DB{
    protected $DBSERVER = "localhost";
    protected $DBUSER = "root";
    protected $DBPASS = "severen";
    protected $DB = "Severen_te";

    public function connect() {
        $result = mysql_connect($this->DBSERVER, $this->DBUSER, $this->DBPASS) or die ("Не могу подключиться" );
        mysql_select_db($this->DB) or die ('Не могу выбрать БД');
        return true;
    }

    public function select($what, $table, $where) {
        $sql = "SELECT $what FROM '". $table ."' WHERE '". $where ."'";
        $result = mysql_query($sql);
        return $this->$result;
    }
}
?>