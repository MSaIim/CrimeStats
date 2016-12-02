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

		// Intialize all the variables
		function __construct()
		{
			$this->query = "";
			$this->table = "ArrestsByRace";

			$this->arrests_offense = $_POST['arrests-offense'];
			$this->arrests_race = $_POST['arrests-race'];
			$this->arrests_compare_white = (isset($_POST['arrests-compare-white'])) ? $_POST['arrests-compare-white'] : "";
			$this->arrests_compare_black = (isset($_POST['arrests-compare-black'])) ? $_POST['arrests-compare-black'] : "";
			$this->arrests_compare_native = (isset($_POST['arrests-compare-native'])) ? $_POST['arrests-compare-native'] : "";
			$this->arrests_compare_asian= (isset($_POST['arrests-compare-asian'])) ? $_POST['arrests-compare-asian'] : "";
			$this->arrests_compare_pacific = (isset($_POST['arrests-compare-pacific'])) ? $_POST['arrests-compare-pacific'] : "";
		}

		// Return the query for the arrests by race table
		public function getQuery()
		{
			// Offense selected and maybe race
			if($this->arrests_offense != "")
			{
				$this->query = "SELECT * FROM " . $this->table . " WHERE `Offense Charged` = :arrests_offense";

				if($this->getRaceQuery())
					$this->query .= " FROM " . $this->table . " WHERE `Offense Charged` = :arrests_offense AND " . $this->arrests_race . " >= 0";
			}
			// Offense not selected and maybe race
			else if($this->arrests_offense == "")
			{
				if($this->getRaceQuery())
					$this->query .= " FROM " . $this->table . " WHERE " . $this->arrests_race . " >= 0";
			}

			return $this->query;
		}

		// Get the bindings for query so PDO can use it
		public function getBindings()
		{
			return array(":arrests_offense"=>$this->arrests_offense);
		}

		// Get the query if Race is selected along with any comparisons
		private function getRaceQuery()
		{
			// Boolean to see if race is selected
			$haveRace = false;

			if($this->arrests_race != "")
			{
				$haveRace = true;
				$this->query = "SELECT `Offense Charged`, Year, Total, " . $this->arrests_race . ", `" . $this->arrests_race . " Percent`";

				if(isset($_POST['arrests-compare-white']) && $this->arrests_compare_white != $this->arrests_race)
					$this->query .= ", " . $this->arrests_compare_white . ", `" . $this->arrests_compare_white . " Percent`";
				if(isset($_POST['arrests-compare-black']) && $this->arrests_compare_black != $this->arrests_race)
					$this->query .= ", " . $this->arrests_compare_black . ", `" . $this->arrests_compare_black . " Percent`";
				if(isset($_POST['arrests-compare-native']) && $this->arrests_compare_native != $this->arrests_race)
					$this->query .= ", " . $this->arrests_compare_native . ", `" . $this->arrests_compare_native . " Percent`";
				if(isset($_POST['arrests-compare-asian']) && $this->arrests_compare_asian != $this->arrests_race)
					$this->query .= ", " . $this->arrests_compare_asian . ", `" . $this->arrests_compare_asian. " Percent`";
				if(isset($_POST['arrests-compare-pacific']) && $this->arrests_compare_pacific != $this->arrests_race)
					$this->query .= ", " . $this->arrests_compare_pacific . ", `" . $this->arrests_compare_pacific . " Percent`";
			}

			return $haveRace;
		}
	}
?>