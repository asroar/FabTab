<?php
class MySingletonClass{
    private $_connection;
    private $_host = "localhost"; // Host name
    private $_username = "root"; // Mysql username
    private $_password = ""; // Mysql password
    private $_database = "fabtab"; // Database name
    private static $_instance = null; //Condition 1 - Presence of a static member variable

///Condition 2 - Locked down the constructor
    private function  __construct() {
        $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);

        // Error handling
        if(mysqli_connect_error()) {
            trigger_error("Failed to conenct to to MySQL: " . mysql_connect_error(), E_USER_ERROR);
        }
    }//Prevent any outside instantiation of this class

///Condition 3 - Prevent any object or instance of that class to be cloned
private function  __clone() { }

///Condition 4 - Have a single globally accessible static method
    public static function getInstance(){
        if( !is_object(self::$_instance) )  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new MySingletonClass();
        return self::$_instance;
    }

///Now we are all done, we can now proceed to have any other method logic we want
//a simple method to echo something
    public function getConnection() {
        return $this->_connection;
    }

    public function search($sql){
        $link= $this->_connection;
        $result = $link->query($sql);
        while($row = $result->fetch_array(MYSQLI_BOTH)){
            echo $row['fullname'].'<br/>';
        }
    }

public function GreetMe()
{
echo '<br/>Hello, this method is called by using a singleton object..';
}
}//END Class

///Testing some calls to that class
$obj2 = MySingletonClass::getInstance();
$obj3 = MySingletonClass::getInstance();
$obj2->GreetMe();
$obj3->GreetMe();

echo '<form method="post">
        <input type="text" placeholder="Search" name="search_text"/>
        <input type="submit" value="Search By Name" name="searchbyname"/>
        <input type="submit" value="Search By Type" name="searchbytype"/>
        </form>';


if(isset($_POST['searchbyname'])){
    $searchText = $_POST['search_text'];
    $obj1 = MySingletonClass::getInstance();
    $sql="SELECT * FROM users WHERE fullname LIKE '%".$searchText."%'";
    $obj1->search($sql);
}

if(isset($_POST['searchbytype'])){
    $searchText = $_POST['search_text'];
    $obj1 = MySingletonClass::getInstance();
    $sql="SELECT * FROM users WHERE type_of_user LIKE '%".$searchText."%'";
    $obj1->search($sql);
}