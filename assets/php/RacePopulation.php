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

		function __construct()
		{
			$this->query = "";
			$this->table = "RacePopulation";
			$this->fields = array();

			$this->pop_state = $_POST['population-states'];
			$this->pop_race = $_POST['population-race'];
			$this->pop_state_compare = $_POST['population-compare-states'];
			$this->pop_percent = isset($_POST['population-percentage']);
		}

		public function getBindings()
		{
			return $this->fields;
		}

		public function getQuery()
		{
			$hasRace = false;
			$query = "";

			// State selected and maybe race
			if($this->pop_state != "")
			{
				// Bind the state
				$this->fields[":state"] = $this->pop_state;

				// Set the columns
				$columns = "state,year,total";
				$query = "SELECT " . $columns . " FROM (";

				// Check if race selected
				if($this->pop_race != "")
				{
					// Race chosen
					$hasRace = true;

					// Set the columns
					if($this->pop_percent)
						$columns .= "," . "(FORMAT ((" . $this->pop_race . "/total * 100), 1)) AS '" . $this->pop_race . " Percentage Of Total Population For State'";
					else
						$columns .= "," . $this->pop_race;

					$query = "SELECT " . $columns . " FROM (";
				}

				// See if race was selected
				if(!$hasRace)
					$query = "SELECT * FROM (";

				// Create query
				if($this->pop_state != "All")
				{
					if($hasRace)
						$this->query .= "SELECT * FROM " . $this->table . " WHERE state = :state AND " . $this->pop_race . " >= 0";
					else
						$this->query .= "SELECT * FROM " . $this->table . " WHERE state = :state";

					// Check if compare state is selected
					if($this->pop_state_compare != "")
					{
						// Bind the state
						$this->fields[":state_compare"] = $this->pop_state_compare;
						$this->query .= " UNION SELECT * FROM " . $this->table . " WHERE state = :state_compare";

						if($hasRace)
							$this->query .= " AND " . $this->pop_race . " >= 0";
					}

					// End query
					$this->query = $query . $this->query . ") AS R ORDER BY state";
				}
				else
				{
					if($hasRace)
						$this->query = "SELECT state,year,total," . $this->pop_race . " FROM " . $this->table . " WHERE " . $this->pop_race . " >= 0";
					else
						$this->query = "SELECT * FROM " . $this->table;
				}
			}

			// State not selected and race selected
			else if($this->pop_race != "")
			{
				// Default race 
				$raceCol = $this->pop_race;

				// Race as percentage
				if($this->pop_percent)
					$raceCol = "(FORMAT ((" . $this->pop_race . "/total * 100), 1)) AS '" . $this->pop_race . " Percentage Of Total Population'";

				$this->query = "SELECT state,year,total," . $raceCol . " FROM " . $this->table . " WHERE " . $this->pop_race . " >= 0";
			}

			// Return it
			return $this->query;
		}
	}
?>