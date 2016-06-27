<?php
//if(!isset($_SESSION)){
//    session_start();
//}

//$con = new PDO("mysql:host=127.0.0.1;dbname=mydb", "root", ""); 
//$con = new PDO("mysql:host=108.179.253.65;dbname=river426_database", "river426_themobi", "Invista2005CTP");

/* Connect to an ODBC database using driver invocation */

/*$dsn = 'mysql:dbname=river426_database;host=127.0.0.1;charset=UTF8';
$user = 'root';
$password = '';
*/


$dsn = 'mysql:dbname=banco_inbanker;host=186.202.152.194;charset=UTF8';
$user = 'banco_inbanker';
$password = 'bdinbanker2016';


try {
    $con = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>