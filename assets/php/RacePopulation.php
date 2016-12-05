<?php
	class RacePopulation
	{
		// Strings for the whole query and table name
		private $query;
		private $table;

		// String values from the form
		private $pop_state;
		private $pop_race;
		private $pop_state_compare;
		private $pop_percent;

		// Binding Array
		private $fields;

		// Columns and clauses
		private $columns;
		private $clauses;

		function __construct()
		{
			$this->query = "";
			$this->table = "RacePopulation";
			$this->fields = array();
			$this->columns = array();
			$this->clauses = array();

			$this->pop_state = $_POST['population-states'];
			$this->pop_race = $_POST['population-race'];
			$this->pop_state_compare = $_POST['population-compare-states'];
			$this->pop_percent = isset($_POST['population-percentage']);
		}

		// Get the bindings for query so PDO can use it
		public function getBindings()
		{
			return $this->fields;
		}

		// Remove last element from column if no results found
		public function tryNewQuery()
		{
			// Pop a select statement and build new query
			array_pop($this->clauses);
			$this->build();

			// Return new query
			return $this->query;
		}

		// Return the query for the race population table
		public function getQuery()
		{
			if($this->pop_state != "" || $this->pop_race != "")
			{
				// Set the fields chosen
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
			
			// Return it
			return $this->query;
		}

		// Build the query
		private function build()
		{
			// Start query
			$this->query = "SELECT ";

			// Add all the columns
			for($i = 0; $i < sizeof($this->columns); $i++)
			{
				$this->query .= $this->columns[$i] . ",";
			}

			// Remove comma at end and add FROM clause
			$this->query = substr($this->query, 0, strlen($this->query) - 1) . " FROM (";

			// Add all the clauses
			for($i = 0; $i < sizeof($this->clauses); $i++)
			{
				$this->query .= $this->clauses[$i] . " UNION ";
			}

			// End query
			if(sizeof($this->clauses) > 0)
				$this->query = substr($this->query, 0, strlen($this->query) - 7) . ") AS R ORDER BY state";
			else
				$this->query = substr($this->query, 0, strlen($this->query) - 1) . $this->table;
		}

		// Set the columns and clauses
		private function setFields()
		{
			// Default columns
			array_push($this->columns, "year");
			array_push($this->columns, "state");
			array_push($this->columns, "total");

			// STATE SELECTED AND MAYBE COMPARISON STATE
			if($this->pop_state != "" && $this->pop_state != "All")
			{
				// Push clause and bind the field
				array_push($this->clauses, "SELECT * FROM " . $this->table . " WHERE state = :pop_state");
				$this->fields[":pop_state"] = $this->pop_state;

				// Check if compare state is up
				if($this->pop_state_compare != "")
				{
					// Push and bind
					array_push($this->clauses, "SELECT * FROM " . $this->table . " WHERE state = :pop_state_compare");
					$this->fields[":pop_state_compare"] = $this->pop_state_compare;
				}
			}
			// RACE SELECTED
			if($this->pop_race != "" && $this->pop_race != "All")
			{
				// Push column
				if($this->pop_percent)
					array_push($this->columns, "(FORMAT ((" . $this->pop_race . "/total * 100), 1)) AS '" . $this->pop_race . " Percentage Of Total Population'");
				else
					array_push($this->columns, $this->pop_race);
			}
		}
	}
?>