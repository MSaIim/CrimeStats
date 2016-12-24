<?php
	require_once("Connection.php");
	require_once("ArrestsByRace.php");
	require_once("PeopleKilled.php");
	require_once("RacePopulation.php");

	class DBCrimeStats extends Connection
	{
		// Connection and sql arrays
		private $column_names = array();
		private $column_values = array();

		// Table classes
		private $arrests;
		private $killed;
		private $population;

		// Misc
		private $emptyTables;
		private $emptyColumns;

		// Constructor
		function __construct()
		{
			// Call super constructor
			parent::__construct();

			// Misc
			$this->emptyTables = array();
			$this->emptyColumns = array();

			// Get column classes
			$this->arrests = new ArrestsByRace();
			$this->killed = new PeopleKilled();
			$this->population = new RacePopulation();
		}

		// ARRESTS BY RACE COLUMN
		public function fetch()
		{
			// See if submit was clicked
			if(isset($_POST['submit']))
			{
				// Get the query from the arrests by race column
				$query = $this->arrests->getQuery();
				$this->execute($query, $this->arrests->getBindings(), "Arrests By Race");

				// Get the query from the arrests by race column
				$query = $this->killed->getQuery();
				$this->execute($query, $this->killed->getBindings(), "People Killed");

				// Get the query from the arrests by race column
				$query = $this->population->getQuery();
				$this->execute($query, $this->population->getBindings(), "Race Population");

				// Print out messages for empty tables
				$this->emptyMessage();
			}
		}

		// Execute the given query, save column names and data values, and create table
		private function execute($query, $fields, $tableName)
		{
			// Only do if query is not empty
			if($query != "")
			{
				// Prepare the query and execute it
				$stmt = $this->conn->prepare($query);
				$stmt->execute($fields);
				$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

				// Check if query returned any results
				if($stmt->rowCount() > 0)
				{
					// Add column names and values
					$this->setColumnsRows($row);

					// Create the table
					$this->createTable($tableName);
				}
				else
					array_push($this->emptyTables, $tableName);
			}
			else
				array_push($this->emptyColumns, $tableName);
		}

		// Add column names and data values
		private function setColumnsRows($row)
		{
			// Clear arrays
			$this->column_names = array();
			$this->column_values = array();

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
			echo '<span class="db-title" style="text-align: left"><a name="' . $tableName . '">' . $tableName . ' Results</a></span>';

			// Start table
			echo "\n\t\t" . '<div class="table-responsive">';
			echo "\n\t\t\t" . '<table class="table table-hover table-bordered">';
			echo "\n\t\t\t\t" . '<tr class="success">';

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
			echo "\n\t\t\t" . '</table>' . "\n\t\t" . '</div>' . "\n\n\t\t";
		}

		// Empty results returned
		private function emptyMessage()
		{
			// Check if any of the results returned nothing
			if(sizeof($this->emptyTables) > 0)
			{
				// String for tables
				$tableString = "";

				echo '<div class="container">' . "\n\t\t\t";
				echo '<div class="row" id="error-message">' . "\n\t\t\t\t";
				echo '<span id="results"><img src="assets/images/error.png" width="24" height="24" />';
				echo 'No results found for the following column(s): </span>' . "\n\t\t\t\t" . '<span id="results-bold">'; 
				
				// Loop through to get tables names
				foreach($this->emptyTables as $table)
					$tableString .= $table . ', ';

				echo substr($tableString, 0, strlen($tableString) - 2) . '</span>';
				echo "\n\t\t\t" . '</div>';

				echo "\n\n\t\t\t" . '<div class="row" id="error-message">';
				echo "\n\t\t\t\t" . '<span id="results"><a href="index.php">Click here</a> to go back and try again.</span>';
				echo "\n\t\t\t" . '</div>' . "\n\t\t" . '</div>' . "\n";
			}

			// Check if any of the columns were filled out
			if(sizeof($this->emptyColumns) == 3)
			{
				// String for tables
				$tableString = "";

				echo '<div class="container">' . "\n\t\t\t";
				echo '<div class="row" id="error-message">' . "\n\t\t\t\t";
				echo '<span id="results"><img src="assets/images/error.png" width="24" height="24" />';
				echo 'Please make sure to fill out the appropriate fields in at least one column.</span>';
				echo "\n\t\t\t" . '</div>';

				echo "\n\n\t\t\t" . '<div class="row" id="error-message">';
				echo "\n\t\t\t\t" . '<span id="results"><a href="index.php">Click here</a> to go back and try again.</span>';
				echo "\n\t\t\t" . '</div>' . "\n\t\t" . '</div>' . "\n";
			}
		}
	}
?>