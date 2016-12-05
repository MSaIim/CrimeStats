<?php
	class ArrestsByRace
	{
		// Strings for the whole query and table name
		private $query;
		private $table;

		// String values from the form
		private $arrests_offense;
		private $arrests_race;
		private $arrests_compare_white;
		private $arrests_compare_black;
		private $arrests_compare_native;
		private $arrests_compare_asian;
		private $arrests_compare_pacific;

		// Binding array
		private $fields;

		// Columns and clauses
		private $columns;
		private $clauses;

		// Intialize all the variables
		function __construct()
		{
			$this->query = "";
			$this->table = "ArrestsByRace";
			$this->fields = array();
			$this->columns = array();
			$this->clauses = array();

			$this->arrests_offense = $_POST['arrests-offense'];
			$this->arrests_race = $_POST['arrests-race'];
			$this->arrests_compare_white = (isset($_POST['arrests-compare-white'])) ? $_POST['arrests-compare-white'] : "";
			$this->arrests_compare_black = (isset($_POST['arrests-compare-black'])) ? $_POST['arrests-compare-black'] : "";
			$this->arrests_compare_native = (isset($_POST['arrests-compare-native'])) ? $_POST['arrests-compare-native'] : "";
			$this->arrests_compare_asian= (isset($_POST['arrests-compare-asian'])) ? $_POST['arrests-compare-asian'] : "";
			$this->arrests_compare_pacific = (isset($_POST['arrests-compare-pacific'])) ? $_POST['arrests-compare-pacific'] : "";
		}

		// Get the bindings for query so PDO can use it
		public function getBindings()
		{
			return $this->fields;
		}

		// Remove last element from column if no results found
		public function tryNewQuery()
		{
			// Pop a race and build new query
			array_pop($this->columns);
			array_pop($this->columns);
			$this->build();

			// Return new query
			return $this->query;
		}

		// Return the query for the arrests by race table
		public function getQuery()
		{
			// Offense selected and maybe race
			if($this->arrests_offense != "")
			{
				// Set the fields
				$this->setFields();

				// Check if race was chosen
				if(sizeof($this->columns) == 3)
				{
					$this->columns = array();
					array_push($this->columns, "*");
				}

				// Build the query
				$this->build();
			}
			// Offense not selected and maybe race
			else if($this->arrests_offense == "" && $this->arrests_race != "")
			{
				$this->setFields();
				$this->build();
			}

			return $this->query;
		}

		// Build the query from the arrays
		private function build()
		{
			// Start query
			$this->query = "SELECT ";

			// Add all the columns
			for($i = 0; $i < sizeof($this->columns); $i++)
			{
				$this->query .= $this->columns[$i] . ",";
			}

			// Remove last comma and add the table name
			$this->query = substr($this->query, 0, strlen($this->query) - 1) . " FROM " . $this->table;

			// Add the clauses
			for($i = 0; $i < sizeof($this->clauses); $i++)
			{
				$this->query .= $this->clauses[$i];
			}
		}

		// Set the columns and clauses
		private function setFields()
		{
			// Columns that will always be in query
			array_push($this->columns, "`Offense Charged`");
			array_push($this->columns, "Year");
			array_push($this->columns, "Total");

			// OFFENSE SELECTED
			if($this->arrests_offense != "")
			{
				// Push clause and bind the field
				array_push($this->clauses, " WHERE `Offense Charged` = :arrests_offense");
				$this->fields[":arrests_offense"] = $this->arrests_offense;
			}
			// RACE SELECTED
			if($this->arrests_race != "")
			{
				// Push column in
				array_push($this->columns, $this->arrests_race);
				array_push($this->columns, "`" . $this->arrests_race . " Percent`");

				// Check if compare races are chosen
				$this->getCompareRace();
			}
		}

		// Get the query if Race is selected along with any comparisons
		private function getCompareRace()
		{
			if(isset($_POST['arrests-compare-white']))
			{
				array_push($this->columns, $this->arrests_compare_white);
				array_push($this->columns, "`" . $this->arrests_compare_white . " Percent`");
			}
			if(isset($_POST['arrests-compare-black']))
			{
				array_push($this->columns, $this->arrests_compare_black);
				array_push($this->columns, "`" . $this->arrests_compare_black . " Percent`");
			}
			if(isset($_POST['arrests-compare-black']))
			{
				array_push($this->columns, $this->arrests_compare_native);
				array_push($this->columns, "`" . $this->arrests_compare_native . " Percent`");
			}
			if(isset($_POST['arrests-compare-black']))
			{
				array_push($this->columns, $this->arrests_compare_asian);
				array_push($this->columns, "`" . $this->arrests_compare_asian . " Percent`");
			}
			if(isset($_POST['arrests-compare-black']))
			{
				array_push($this->columns, $this->arrests_compare_pacific);
				array_push($this->columns, "`" . $this->arrests_compare_pacific . " Percent`");
			}
		}
	}
?>