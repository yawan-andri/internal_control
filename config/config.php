<?php
$serverName = "192.168.0.179";   
$database = "IT";  

// Get UID and PWD from application-specific files.   
$uid = "sa";  
$pwd = "test";  

try {  
	$conn = new PDO( "sqlsrv:server=$serverName;Database = $database", $uid, $pwd);   
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );   
}  

catch( PDOException $e ) {  
	die( "Error connecting to SQL Server" );   
}  
