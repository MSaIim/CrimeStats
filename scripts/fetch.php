<?php
	include("DBCrimeStats.php");

	// Open a connection
	$conn = new DBCrimeStats();

	// Generate table from the arrests by race form
	$conn->arrestsByRace();
	
	// Close the connection
	$conn->close();
?>