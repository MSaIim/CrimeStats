<?php
	class Connection
	{
		protected $conn;

		function __construct()
		{
			// Connection details
			$username = "Username";
			$password = "Password";
			$database = "CrimeStats";
			$hostname = "Hostname";

			// Connect to database
			$this->conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		public function close()
		{
			$this->conn = null;
		}
	}
?>