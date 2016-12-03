<?php
	class PeopleKilled
	{
		// Strings for the whole query and table name
		private $query;
		private $table;

		// String values from the form
		private $killed_state;
		private $killed_name;
		private $killed_gender;
		private $killed_race;
		private $killed_classification;
		private $killed_armed;
		private $killed_agency;

		// Binding array
		private $fields;

		// Intialize all the variables
		function __construct()
		{
			$this->query = "";
			$this->table = "PersonKilled";
			$this->fields = array();

			$this->killed_state = $_POST['killed-state'];
			$this->killed_name = $_POST['killed-name'];
			$this->killed_race = $_POST['killed-race'];
			$this->killed_gender = (isset($_POST['killed-gender'])) ? $_POST['killed-gender'] : "";
			$this->killed_classification = $_POST['killed-classification'];
			$this->killed_armed = $_POST['killed-armed'];
			$this->killed_agency = $_POST['killed-agency'];
		}

		// Return the query for the person killed table
		public function getQuery()
		{
			// Counter to see if anything is selected
			$counter = 0;
			$columns = "uid, name, age, gender, raceethnicity, state, classification, lawenforcementagency, armed";

			if($this->killed_state != "")
			{
				$this->query = "SELECT " . $columns . " FROM " . $this->table . " WHERE state = :state";

				// Increase the counter
				$counter++;

				// Add to binding array
				$this->fields[":state"] = $this->killed_state;
			}
			if($this->killed_name != "")
			{
				if($counter == 0)
					$this->query = "SELECT " . $columns . " FROM " . $this->table . " WHERE name = :name";
				else
					$this->query .= " AND name = :name";

				// Increase the counter
				$counter++;

				// Add to binding array
				$this->fields[":name"] = $this->killed_name;
			}
			if($this->killed_race != "")
			{
				if($counter == 0)
					$this->query = "SELECT " . $columns . " FROM " . $this->table . " WHERE raceethnicity = :raceethnicity";
				else
					$this->query .= " AND raceethnicity = :raceethnicity";

				// Increase the counter
				$counter++;

				// Add to binding array
				$this->fields[":raceethnicity"] = $this->killed_race;
			}
			if($this->killed_gender != "Any")
			{
				if($counter == 0)
					$this->query = "SELECT " . $columns . " FROM " . $this->table . " WHERE gender = :gender";
				else
					$this->query .= " AND gender = :gender";

				// Increase the counter
				$counter++;

				// Add to binding array
				$this->fields[":gender"] = $this->killed_gender;
			}
			if($this->killed_classification != "")
			{
				if($counter == 0)
					$this->query = "SELECT " . $columns . " FROM " . $this->table . " WHERE classification = :classification";
				else
					$this->query .= " AND classification = :classification";

				// Increase the counter
				$counter++;

				// Add to binding array
				$this->fields[":classification"] = $this->killed_classification;
			}
			if($this->killed_armed != "")
			{
				if($counter == 0)
					$this->query = "SELECT " . $columns . " FROM " . $this->table . " WHERE armed = :armed";
				else
					$this->query .= " AND armed = :armed";

				// Increase the counter
				$counter++;

				// Add to binding array
				$this->fields[":armed"] = $this->killed_armed;
			}
			if($this->killed_agency != "")
			{
				if($counter == 0)
					$this->query = "SELECT " . $columns . " FROM " . $this->table . " WHERE lawenforcementagency = :lawenforcementagency";
				else
					$this->query .= " AND lawenforcementagency = :lawenforcementagency";

				// Increase the counter
				$counter++;

				// Add to binding array
				$this->fields[":lawenforcementagency"] = $this->killed_agency;
			}

			return $this->query;
		}

		// Get the bindings for query so PDO can use it
		public function getBindings()
		{
			return $this->fields;
		}
	}
?>