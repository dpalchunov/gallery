 <?php
 class  DBConnector {
    public static getDBConnection {
    $config = array(
        'host'     => 'localhost',
        'port'     => 3307,       
        'username' => 'root',
        'passwd'   => 'dba',
        'dbname'   => 'StrunkovaDB',
        'charset'  => 'utf8',
        'debug'    => true
        $db = new goDB($config);
        return $db;   
    }  
 }
 ?>