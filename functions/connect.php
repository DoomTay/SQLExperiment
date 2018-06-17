<?php
try
{
	session_start();
	
	$host = "localhost";
	$root = "root";
	$password = "zaWarudo";
	
	$worldDB = new PDO("mysql:dbname=world;host=$host", $root, $password);
	$accounts = new PDO("mysql:dbname=accounts;host=$host", $root, $password);
}
catch (PDOException $e)
{
	die("Connection failed: ".$e->getMessage());
}
?>