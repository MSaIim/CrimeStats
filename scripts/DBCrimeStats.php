<?php
	class DBCrimeStats
	{
		private $conn;
		private $column_names = array();
		private $column_values = array();

		// Constructor
		function __construct()
		{
			// Connection details
			$username = "YOUR_USERNAME_HERE";
			$password = "YOUR_PASSWORD_HERE";
			$database = "YOUR_DATABASE_HERE";
			$hostname = "YOUR_HOSTNAME_HERE";

			// Connect to database
			$this->conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		// Close the connection
		public function close() 
		{ 
			$this->conn = null; 
		}

		// Get the offense
		public function arrestsByRace()
		{
			// See if submit was clicked
			if(isset($_POST['submit']))
			{
				// Get the values from the form
				$offense = $_POST['arrests-offense'];
				$race = $_POST['arrests-race'];
				$arrests_gt = $_POST['arrests-gt'];
				$arrests_lt = $_POST['arrests-lt'];
				$arrests_percent_gt = $_POST['arrests-percent-gt'];
				$arrests_percent_lt = $_POST['arrests-percent-lt'];

				// Default query (!!! CHANGE THIS !!!)
				$query = "SELECT * FROM ArrestsByRace ";

				// Make correct query
				if($offense != "Any")
					$query = "SELECT * FROM ArrestsByRace WHERE `Offense Charged` = :offense";
				if($offense != "Any" && $race != "Any")
					$query = "SELECT `Offense Charged`, Total, " . $race . ", `" . $race . " Percent` FROM ArrestsByRace WHERE `Offense Charged` = :offense AND " . $race . " >= 0";
				if($offense == "Any" && $race != "Any")
					$query = "SELECT `Offense Charged`, Total, " . $race . ", `" . $race . " Percent` FROM ArrestsByRace WHERE " . $race . " >= 0";

				// Execute the query
				$this->execute($query);

				// Create the table
				$this->createTable("Arrests By Race", true);
			}
		}

		// Execute the given query and save column names and data values
		private function execute($query)
		{
			// Prepare the query and execute it
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':offense', $offense, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// Add column names and values
			$this->setColumnsRows($row);
		}

		// Add column names and data values
		private function setColumnsRows($row, $clear)
		{
			// Clear arrays
			if($clear == true)
			{
				$this->column_names = array();
				$this->column_values = array();
			}

			// Add the column names and data values
			foreach($row as $result)
			{
				foreach($result as $key=>$value)
				{
					// Only add column name in array if not in array
					if(!in_array($key, $this->column_names))
						array_push($this->column_names, $key);

					// Add column data value
					array_push($this->column_values, $value);
				}
			}
		}

		// Create table
		private function createTable($tableName)
		{
			// Show table name
			echo '<span class="db-title">' . $tableName . ' Results</span>';

			// Start table
			echo "\n\t\t" . '<div class="table-responsive">' . "\n\t\t\t" . '<table class="table table-hover table-bordered">' . "\n\t\t\t\t" . '<tr class="success">';

			// Add the column names
			for($i = 0; $i < sizeof($this->column_names); $i++)
			{
				echo "\n\t\t\t\t\t" . '<th>' . $this->column_names[$i] . "</th>";
			}
			echo "\n\t\t\t\t" . '</tr>';

			// Add the column data values
			for($i = 0; $i < sizeof($this->column_values); $i++)
			{
				// Start a new row
				if($i % sizeof($this->column_names) == 0)
					echo "\n\t\t\t\t" . '<tr>';

				// Print out data
				echo "\n\t\t\t\t\t" . '<td>' . $this->column_values[$i] . '</td>';

				// End row
				if(($i + 1) % sizeof($this->column_names) == 0)
					echo "\n\t\t\t\t" . '</tr>';
			}

			// End table
			echo "\n\t\t\t" . '</table>' . "\n\t\t" . '</div>' . "\n\t\t";
		}
	}
?>