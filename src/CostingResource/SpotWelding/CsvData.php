<?php namespace CostingResource\SpotWelding;

class CsvData extends \CostingResource\CsvData implements DataInterface {

	private $countries;
	private $machines;
	private $loadTimes;
	private $settings;

	private $dataPath;

	public function __construct(array $data = array())
	{
		if (isset($data['countries'])) $this->countries = $this->readCsvString($data['countries']);
		if (isset($data['machines'])) $this->machines = $this->readCsvString($data['machines']);
		if (isset($data['load_times'])) $this->loadTimes = $this->readCsvString($data['load_times']);
		if (isset($data['settings'])) $this->settings = $this->readCsvString($data['settings']);

		$this->dataPath = __DIR__ . '/../../../data/spot_welding/';
	}
	
	public function getMachines()
	{
		if ($this->machines === null)
			$this->machines = $this->readCsv(realpath($this->dataPath . 'machines.csv'));

		return $this->machines;
	}

	public function getCountries()
	{
		if ($this->countries === null)
			$this->countries = $this->readCsv(realpath($this->dataPath . 'countries.csv'));

		return $this->countries;
	}

	public function getLoadTimes()
	{
		if ($this->loadTimes === null)
			$this->loadTimes = $this->readCsv(realpath($this->dataPath . 'load_times.csv'));

		return $this->loadTimes;
	}

	public function getSettings()
	{
		if ($this->settings === null)
			$this->settings = $this->readCsv(realpath($this->dataPath . 'settings.csv'));

		return $this->settings[0];
	}



	public function getLoadTimesForWeight($weight)
	{
		$loadTimes = $this->getLoadTimes();
		
		foreach ($loadTimes as $loadTime) {
			if ($weight >= $loadTime->weight_low && $weight < $loadTime->weight_high) {
				$result = new \stdClass;
				$result->load = $loadTime->load;
				$result->unload = $loadTime->unload;
				return $result;
			}
		}
		return null;
	}
}