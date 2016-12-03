<?php
	require_once("Connection.php");

	class ListModal extends Connection
	{
		private $column_names;
		private $column_values;

		public function getList($query)
		{
			// Call super constructor
			parent::__construct();
			
			// Execute query
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// Set the data
			$this->setColumnsRows($row);

			// Create table
			$this->createTable();
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

		private function createTable()
		{
			// Start table
			echo '<table class="table table-hover table-bordered">';
			echo '<tr class="success">';

			// Add the column names
			for($i = 0; $i < sizeof($this->column_names); $i++)
			{
				echo '<th>' . $this->column_names[$i] . "</th>";
			}
			echo '</tr>';

			// Add the column data values
			for($i = 0; $i < sizeof($this->column_values); $i++)
			{
				// Start a new row
				if($i % sizeof($this->column_names) == 0)
					echo '<tr>';

				// Print out data
				echo '<td>' . $this->column_values[$i] . '</td>';

				// End row
				if(($i + 1) % sizeof($this->column_names) == 0)
					echo '</tr>';
			}

			// End table
			echo '</table>';
		}
	}
?>