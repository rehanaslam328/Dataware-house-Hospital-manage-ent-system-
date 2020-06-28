<?php
 $serverName = "WEBDEVELOPER\SQLEXPRESS"; 
// $serverName = "localhost"; 
// $uid = "root";   
// $pwd = "";  
$databaseName = "hospitalstar"; 

$connectionInfo = array("Database"=>$databaseName); 

/* Connect using SQL Server Authentication. */  
$con = sqlsrv_connect( $serverName, $connectionInfo);  

