<?php 

/*
	Check to see if the database is set to local or live
	Set different db variables to the correct constants depending on production or local state
	
*/

if (DB_STATE == "local") {
	
	$hostname = DB_LOCAL_HOST;
	$user = DB_LOCAL_USER;
	$password = DB_LOCAL_PASSWORD;
	
	$database = DB_LOCAL_NAME;

} else {					
	$hostname = DB_HOST;
	$user = DB_USER;			
	$password = DB_PASSWORD;
	
	$database = DB_NAME;
}

/* 
	connect to the database using PDO
	or display connection error
*/

try {
	$db = new PDO("mysql:host=$hostname;dbname=$database", $user, $password);
	
} catch(PDOException $e){
	
	echo $e->getMessage();
}

// Set the PDO error mode
// comment out this line when you run this for real
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
?>