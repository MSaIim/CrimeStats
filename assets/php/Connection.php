<?php
	class Connection
	{
		protected $conn;

		function __construct()
		{
			// Connection details
			$username = "YOUR_USERNAME";
			$password = "YOUR_PASSWORD";
			$database = "YOUR_DATABASE";
			$hostname = "YOUR_HOSTNAME";

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