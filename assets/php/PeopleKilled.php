<?php
	class PeopleKilled
	{
		// Strings for the whole query and table name
		private $query;
		private $table;

		// String values from the form
		private $killed_state;
		private $killed_race;
		private $killed_race_count;
		private $killed_gender;
		private $killed_month;
		private $killed_month_count;
		private $killed_classification;
		private $killed_armed;

		// Binding array
		private $fields;

		// MISC
		private $counter;

		// Intialize all the variables
		function __construct()
		{
			$this->query = "";
			$this->table = "PersonKilled";
			$this->fields = array();
			$this->counter = 0;

			$this->killed_state = $_POST['killed-state'];
			$this->killed_race = $_POST['killed-race'];
			$this->killed_month_count = (isset($_POST['killed-race-count'])) ? $_POST['killed-race-count'] : "";
			$this->killed_gender = (isset($_POST['killed-gender'])) ? $_POST['killed-gender'] : "";
			$this->killed_month = $_POST['killed-month'];
			$this->killed_month_count = (isset($_POST['killed-month-count'])) ? $_POST['killed-month-count'] : "";
			$this->killed_classification = $_POST['killed-classification'];
			$this->killed_armed = $_POST['killed-armed'];
		}

		// Get the bindings for query so PDO can use it
		public function getBindings()
		{
			return $this->fields;
		}

		// Special queries
		public function getQuery()
		{
			// COMPARE THE RACES
			if(isset($_POST['killed-race-count']) && $this->killed_race != "")
			{
				if($this->killed_race != "All")
				{
					$columns = $this->build("year,") . "count(*) as 'People Killed by Police Officer'";
					$query = "SELECT " . $columns . " FROM Race, " . $this->table . $this->query . " AND race = raceethnicity GROUP BY year ";
				}
				else
				{
					// Set the columns and query
					$this->killed_race = "White";
					$columns = $this->build("year,") . "count(*) as 'People Killed by Police Officer'";
					$query = "SELECT " . $columns . " FROM Race, " . $this->table . $this->query . " AND race = raceethnicity GROUP BY year ";

					// Union with other races
					$this->query = "";
					$this->killed_race = "Black";
					$columns = $this->build("year,") . "count(*) as 'People Killed by Police Officer'";
					$query .= "UNION ALL SELECT " . $columns . " FROM Race, " . $this->table . $this->query . " AND race = raceethnicity GROUP BY year ";

					$this->query = "";
					$this->killed_race = "Native American";
					$columns = $this->build("year,") . "count(*) as 'People Killed by Police Officer'";
					$query .= "UNION ALL SELECT " . $columns . " FROM Race, " . $this->table . $this->query . " AND race = raceethnicity GROUP BY year ";

					$this->query = "";
					$this->killed_race = "Asian/Pacific Islander";
					$columns = $this->build("year,") . "count(*) as 'People Killed by Police Officer'";
					$query .= "UNION ALL SELECT " . $columns . " FROM Race, " . $this->table . $this->query . " AND race = raceethnicity GROUP BY year";
				}

				// Save it
				$this->query = $query;
			}
			// GET KILLED COUNT PER MONTH
			else if(isset($_POST['killed-month-count']) && $this->killed_month != "")
			{
				// Set the columns
				$columns = $this->build("year,") . "count(*) as 'People Killed by Police Officer'";

				// Build the query
				$query = "SELECT " . $columns . " FROM " . $this->table . $this->query;
				$query .= " GROUP BY month ORDER BY field(month,'January','February','March','April','May','June','July','August','September','October','November','December')";
				$this->query = $query;
			}
			// EVERYTHING ELSE
			else 
			{
				// Build the WHERE and AND Clauses
				if($this->build("") != "")
				{
					// Set the columns
					$columns = "uid,name,age,gender,raceethnicity,month,year,state,classification,lawenforcementagency,armed";

					// Build query
					$query = "SELECT " . $columns . " FROM " . $this->table . $this->query;
					$this->query = $query;
				}
			}

			// Return the query
			return $this->query;
		}

		// See if anything is selected
		private function build($columns)
		{	
			// Boolean for WHERE or AND
			$firstChosen = false;

			// STATE SELECTED
			if($this->killed_state != "")
			{
				// Add column
				if(isset($_POST['killed-race-count']) && $this->killed_state != "All")
					$columns .= "state,";
				else if(isset($_POST['killed-month-count']) && $this->killed_state != "All")
					$columns .= "state,";
				else if(!isset($_POST['killed-race-count']) && !isset($_POST['killed-month-count']))
					$columns .= "state,";s

				// Add where clause and bind the field
				if($this->killed_state != "All")
				{
					$this->query .= " WHERE state = :state";
					$this->fields[":state"] = $this->killed_state;

					// First chosen
					$firstChosen = true;
				}
			}
			// RACE SELECTED
			if($this->killed_race != "")
			{
				// Add column
				$columns .= "raceethnicity,";

				// Add where or and clause and bind field
				if($this->killed_race != "All")
				{
					$bindingIndex = ":raceethnicity" . $this->counter++;
					$this->query .= (!$firstChosen) ? " WHERE raceethnicity = " . $bindingIndex : " AND raceethnicity = " . $bindingIndex;
					$this->fields[$bindingIndex] = $this->killed_race;

					// First field chosen
					$firstChosen = true;
				}
			}
			// GENDER SELECTED
			if($this->killed_gender != "Any")
			{
				// Add column
				$columns .= "gender,";

				// Add where or and clause and bind field
				$this->query .= (!$firstChosen) ? " WHERE gender = :gender" : " AND gender = :gender";
				$this->fields[":gender"] = $this->killed_gender;

				// First field chosen
				$firstChosen = true;
			}
			// MONTH SELECTED
			if($this->killed_month != "")
			{
				// Add column
				if(isset($_POST['killed-race-count']) && $this->killed_month != "All")
					$columns .= "month,";
				else if(!isset($_POST['killed-race-count']))
					$columns .= "month,";

				// Add where or and clause
				if($this->killed_month != "All")
				{
					// Add where or and clause and bind field
					$this->query .= (!$firstChosen) ? " WHERE month = :month" : " AND month = :month";
					$this->fields[":month"] = $this->killed_month;

					// First field chosen
					$firstChosen = true;
				}
			}
			// CLASSIFICATION SELECTED
			if($this->killed_classification != "")
			{
				// Add column
				$columns .= "classification,";

				// Add where or and clause and bind field
				$this->query .= (!$firstChosen) ? " WHERE classification = :classification" : " AND classification = :classification";
				$this->fields[":classification"] = $this->killed_classification;

				// First field chosen
				$firstChosen = true;
			}
			// ARMED SELECTED
			if($this->killed_armed != "")
			{
				// Add column
				$columns .= "armed,";

				/// Add where or and clause and bind field
				$this->query .= (!$firstChosen) ? " WHERE armed = :armed" : " AND armed = :armed";
				$this->fields[":armed"] = $this->killed_armed;

				// First field chosen
				$firstChosen = true;
			}

			// Return the columns
			return $columns;
		}
	}
?>