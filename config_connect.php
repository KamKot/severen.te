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

    /*public function processRowSet($rowSet, $singleRow=false)
    {
        $resultArray = array();
        while($row = mysql_fetch_assoc($rowSet))
        {
            array_push($resultArray, $row);
        }
        if($singleRow === true)
            return $resultArray[0];
        return $resultArray;
    }*/


    public function select($table, $where) {
        $sql = "SELECT * FROM '". $table ."' WHERE $where";
        $result = mysql_query($sql);
        return $this->$result;
    }
}
?>