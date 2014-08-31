 <?php
 class  DBConnector {
    public static function getDBConnection() {
    $config = array(
        'host'     => '127.0.0.1',
        'username' => 'root',
        'passwd'   => 'dba',
        'dbname'   => 'StrunkovaDB',
        'charset'  => 'utf8',
        'debug'    => true);
        $db = new goDB($config);
        return $db;   
    }  
 }
 ?>