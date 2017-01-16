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

		// Columns and clauses
		private $columns;
		private $clauses;

		// MISC
		private $counter;

		// Intialize all the variables
		function __construct()
		{
			$this->query = "";
			$this->table = "PersonKilled";
			$this->fields = array();
			$this->columns = array();
			$this->clauses = array();
			$this->counter = 0;

			$this->killed_state = $_POST['killed-state'];
			$this->killed_race = $_POST['killed-race'];
			$this->killed_race_count = isset($_POST['killed-race-count']);
			$this->killed_gender = (isset($_POST['killed-gender'])) ? $_POST['killed-gender'] : "";
			$this->killed_month = $_POST['killed-month'];
			$this->killed_month_count = isset($_POST['killed-month-count']);
			$this->killed_classification = $_POST['killed-classification'];
			$this->killed_armed = $_POST['killed-armed'];
		}

		// Get the bindings for query so PDO can use it
		public function getBindings()
		{
			return $this->fields;
		}

		// Try new query by removing parameters
		public function tryNewQuery()
		{
			array_pop($this->columns);
			array_pop($this->clauses);
			$this->build();

			return $this->query;
		}

		public function getQuery()
		{
			// COMPARE THE RACES
			if(isset($_POST['killed-race-count']) && $this->killed_race != "")
			{
				if($this->killed_race != "All")
				{
					// Push the columns
					array_push($this->columns, "year");
					$this->setFields();
					array_push($this->columns, "count(*) as 'People Killed By Police Officer'");

					// Build the query
					$this->build();
				}
				else
				{
					// Do white
					$this->killed_race = "White";
					$this->setFields();
					array_push($this->columns, "count(*) as 'People Killed By Police Officer'");
					$this->build();

					// Union the rest
					$this->killed_race = "Black";
					$this->setFields();
					array_push($this->columns, "count(*) as 'People Killed By Police Officer'");
					$this->build();

					$this->killed_race = "Native American";
					$this->setFields();
					array_push($this->columns, "count(*) as 'People Killed By Police Officer'");
					$this->build();

					$this->killed_race = "Asian/Pacific Islander";
					$this->setFields();
					array_push($this->columns, "count(*) as 'People Killed By Police Officer'");
					$this->build();
				}
			}
			// GET KILLED COUNT PER MONTH
			else if(isset($_POST['killed-month-count']) && $this->killed_month != "")
			{
				// Push the columns
				array_push($this->columns, "year");
				$this->setFields();
				array_push($this->columns, "count(*) as 'People Killed By Police Officer'");

				// Build the query
				$this->build();
			}
			// EVERYTHING ELSE
			else if($this->killed_state != "" || $this->killed_race != "" || $this->killed_gender != "Any" 
					|| $this->killed_month != "" || $this->killed_classification != "" || $this->killed_armed != "")
			{
				$this->setFields();
				$this->build();
			}

			// Return it
			return $this->query;
		}

		private function build()
		{
			// Start query
			if(strlen($this->query) == 0)
				$this->query = "SELECT ";
			else if(strlen($this->query) > 0)
				$this->query .= " UNION ALL SELECT ";

			// Add all the columns
			for($i = 0; $i < sizeof($this->columns); $i++)
			{
				$this->query .= $this->columns[$i] . ",";
			}

			// Remove comma and add FROM clause
			$this->query = substr($this->query, 0, strlen($this->query) - 1) . " FROM " . $this->table;

			// Add all clauses
			for($i = 0; $i < sizeof($this->clauses); $i++)
			{
				$this->query .= $this->clauses[$i];
			}

			// Compare race checked
			if((isset($_POST['killed-race-count']) || $this->killed_race == "All") && $this->killed_month != "All")
				$this->query .= " GROUP BY year";
			else if(isset($_POST['killed-month-count']))
				$this->query .= " GROUP BY year, month ORDER BY field(month,'January','February','March','April','May','June','July','August','September','October','November','December')";
		}

		// See if anything is selected
		private function setFields()
		{	
			// Boolean for clauses
			$firstChosen = false;

			// Default columns
			if(!$this->killed_race_count && !$this->killed_month_count)
			{
				array_push($this->columns, "name", "age", "gender", "raceethnicity", "month", "year");
				array_push($this->columns, "state", "classification", "lawenforcementagency", "armed");
			}
			else if($this->killed_race_count)
			{
				$this->columns = array();
				$this->clauses = array();
				array_push($this->columns, "year");
			}

			// STATE SELECTED
			if($this->killed_state != "")
			{
				// Push the column
				if(!in_array("state", $this->columns))
				{
					if((isset($_POST['killed-race-count']) || isset($_POST['killed-month-count'])) && $this->killed_state != "All")
						array_push($this->columns, "state");
					else if(!isset($_POST['killed-race-count']) && !isset($_POST['killed-month-count']))
						array_push($this->columns, "state");
				}

				// Push the where clause
				if($this->killed_state != "All")
				{
					array_push($this->clauses, " WHERE state = :state");
					$this->fields[":state"] = $this->killed_state;

					$firstChosen = true;
				}
			}
			// RACE SELECTED
			if($this->killed_race != "")
			{
				// Push the column
				if(!in_array("raceethnicity", $this->columns))
					array_push($this->columns, "raceethnicity");

				if($this->killed_race != "All")
				{
					// Key for binding
					$key = ":raceethnicity" . $this->counter++;

					// Push and bind
					if($firstChosen)
						array_push($this->clauses, " AND raceethnicity = " . $key);
					else
						array_push($this->clauses, " WHERE raceethnicity = " . $key);

					// Bind field
					$this->fields[$key] = $this->killed_race;

					// First field chosen
					$firstChosen = true;
				}
			}
			// GENDER SELECTED
			if($this->killed_gender != "")
			{
				// Push the column
				if(!in_array("gender", $this->columns))
				{
					if((isset($_POST['killed-race-count']) || isset($_POST['killed-month-count'])) && $this->killed_gender != "Any")
						array_push($this->columns, "gender");
					else if(!isset($_POST['killed-race-count']) && !isset($_POST['killed-month-count']))
						array_push($this->columns, "gender");
				}

				// Push the where clause
				if($this->killed_gender != "Any")
				{
					// Push and bind
					if($firstChosen)
						array_push($this->clauses, " AND gender = :gender");
					else
						array_push($this->clauses, " WHERE gender = :gender");

					$this->fields[":gender"] = $this->killed_gender;

					// First field chosen
					$firstChosen = true;
				}
			}
			// MONTH SELECTED
			if($this->killed_month != "")
			{	
				// Push the column
				if(!in_array("month", $this->columns))
				{
					if(isset($_POST['killed-race-count']) && $this->killed_month != "All")
						array_push($this->columns, "month");
					else if(isset($_POST['killed-month-count']))
						array_push($this->columns, "month");
					else if(!isset($_POST['killed-race-count']) && !isset($_POST['killed-month-count']))
						array_push($this->columns, "month");
				}

				// Push the where clause
				if($this->killed_month != "All")
				{
					// Push and bind
					if($firstChosen)
						array_push($this->clauses, " AND month = :month");
					else
						array_push($this->clauses, " WHERE month = :month");

					$this->fields[":month"] = $this->killed_month;

					// First field chosen
					$firstChosen = true;
				}
			}
			// CLASSIFICATION SELECTED
			if($this->killed_classification != "")
			{
				// Push the column
				if(!in_array("classification", $this->columns))
					array_push($this->columns, "classification");

				// Push and bind
				if($firstChosen)
					array_push($this->clauses, " AND classification = :classification");
				else
					array_push($this->clauses, " WHERE classification = :classification");

				$this->fields[":classification"] = $this->killed_classification;

				// First field chosen
				$firstChosen = true;
			}
			// CLASSIFICATION SELECTED
			if($this->killed_armed != "")
			{
				// Push the column
				if(!in_array("armed", $this->columns))
					array_push($this->columns, "armed");

				// Push and bind
				if($firstChosen)
					array_push($this->clauses, " AND armed = :armed");
				else
					array_push($this->clauses, " WHERE armed = :armed");

				$this->fields[":armed"] = $this->killed_armed;

				// First field chosen
				$firstChosen = true;
			}
		}
	}
?>