<?php
	class RacePopulation
	{
		// Strings for the whole query and table name
		private $query;
		private $table;

		// String values from the form
		private $pop_state;
		private $pop_race;

		function __construct()
		{
			$this->query = "";
			$this->table = "RacePopulation";

			$this->pop_state = $_POST['population-states'];
			$this->pop_race = $_POST['population-race'];
		}

		public function getQuery()
		{
			return $this->query;
		}

		public function getBindings()
		{
			return array();
		}
	}
?>