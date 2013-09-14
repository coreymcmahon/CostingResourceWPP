<?php namespace CostingResource;

class CsvData {

	public function readCsv($file)
	{
		// open the file and create an array where each element is a row
		return $this->readCsvString(file_get_contents($file));
	}

	public function readCsvString($string)
	{
		$lines = explode("\n", $string);
		$rows = array();
		// ... take the row and split it on commas
		foreach ($lines as $line)
			$rows[] = explode(',', $line);

		// pull off the first element which will contain the keys
		$keys = array_shift($rows);
		$result = array();

		// now loop through and create the result set
		foreach ($rows as $row) {
			$result[] = new \stdClass;
			foreach ($row as $index => $value) {
				$result[count($result)-1]->{$keys[$index]} = $this->parseValue($value);
			}
		}
		return $result;
	}

	public function parseValue($value)
	{
		if ($value[0] === '"') return str_replace('"', '', $value);
		if (strpos($value,'.')) return (float)$value;
		return (int)$value;
	}
	
}