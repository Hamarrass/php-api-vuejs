<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers:, Content-Type");
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');
header('Access-Control-Allow-Credentials: true');


	$databaseUsername = 'root';
	$databasePassword = '';
	$pdo_conn = new PDO( 'mysql:host=localhost;dbname=crud_vuejs', $databaseUsername, $databasePassword );


        //table todo 
	// $sql = "CREATE TABLE todo(
	// 	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	// 	title VARCHAR(30)  NULL,
	// 	description text   NULL,
	// 	etat char(30)  NULL,
	// 	)";
?>
