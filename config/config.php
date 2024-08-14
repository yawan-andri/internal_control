<?php
$serverName = "192.168.0.102";   
$database = "IT";  

// Get UID and PWD from application-specific files.   
$uid = "subsuper";  
$pwd = "gulacokelat";  

try {  
	$conn = new PDO( "sqlsrv:server=$serverName;Database = $database", $uid, $pwd);   
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );   
}  

catch( PDOException $e ) {  
	die( "Error connecting to SQL Server" );   
}  