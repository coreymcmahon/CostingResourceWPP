<?php namespace CostingResource\Cutting;

class CsvData extends \CostingResource\CsvData implements DataInterface {

	const COUNTRIES_CSV      = 'countries.csv';
	const CUTTING_SPEEDS_CSV = 'cutting_speeds.csv';
	const MACHINES_CSV       = 'machines.csv';
	const MATERIALS_CSV      = 'materials.csv';
	const SETTINGS_CSV       = 'settings.csv';
	const START_HOLES_CSV    = 'start_holes.csv';

	private $countriesData;
	private $cuttingSpeedsData;
	private $machinesData;
	private $materialsData;
	private $settingsData;
	private $startHolesData;

	public function __construct(array $csvs = null)
	{
		if ($csvs !== null) {
			$this->countriesData = $this->readCsvString($csvs['countries']);
			$this->cuttingSpeedsData = $this->readCsvString($csvs['cutting_speeds']);
			$this->machinesData = $this->readCsvString($csvs['machines']);
			$this->materialsData = $this->readCsvString($csvs['materials']);
			$this->settingsData = $this->readCsvString($csvs['settings']);
			$this->startHolesData = $this->readCsvString($csvs['start_holes']);
		}
		
		$this->dataPath = __DIR__ . '/../../../data/cutting/';
	}

	public function isDataPrepared() 
	{
		/* not relevant for CSVs */
		return true;
	}

	public function getMaterials()
	{
		if ($this->materialsData === null) $this->materialsData = $this->readCsv($this->dataPath . self::MATERIALS_CSV);
		return $this->materialsData;
	}

	public function getMachines()
	{
		if ($this->machinesData === null) $this->machinesData = $this->readCsv($this->dataPath . self::MACHINES_CSV);
		return $this->machinesData;
	}

	public function getCountries()
	{
		if ($this->countriesData === null) $this->countriesData = $this->readCsv($this->dataPath . self::COUNTRIES_CSV);
		return $this->countriesData;
	}

	public function getMaterial($id)
	{
		$materials = $this->getMaterials();
		foreach ($materials as $material) {
			if ($material->id == $id) return $material;
		}
		return null;
	}
	
	public function getMachine($id)
	{
		$machines = $this->getMachines();
		foreach($machines as $machine) {
			if ($machine->id == $id) return $machine;
		}
		return null;
	}

	public function getCountry($id)
	{
		$countries = $this->getCountries();
		foreach($countries as $country) {
			if ($country->id == $id) return $country;
		}
		return null;
	}

	public function getLastCuttingSpeedEntryForMaterial($materialId)
	{
		if ($this->cuttingSpeedsData === null) $this->cuttingSpeedsData = $this->readCsv($this->dataPath . self::CUTTING_SPEEDS_CSV);		
		
		$last = null;
		foreach ($this->cuttingSpeedsData as $cuttingSpeed) {
			if ($cuttingSpeed->material_id == $materialId) {
				if ($last === null) {
					$last = $cuttingSpeed;
				} elseif($cuttingSpeed->thickness > $last->thickness) {
					$last = $cuttingSpeed;
				}
			}
		}
		return $last;
	}

	public function getStartHoleByMaterialAndThickness($materialId, $thickness)
	{
		if ($this->startHolesData === null) $this->startHolesData = $this->readCsv($this->dataPath . self::START_HOLES_CSV);

		foreach ($this->startHolesData as $startHole) {
			if ($startHole->material_id == $materialId && $startHole->thickness == $thickness) {
				return $startHole->start_hole;
			}
		}
		return null;
	}

	public function getCuttingSpeedByMaterialAndThickness($materialId, $thickness)
	{
		if ($this->cuttingSpeedsData === null) $this->cuttingSpeedsData = $this->readCsv($this->dataPath . self::CUTTING_SPEEDS_CSV);
		
		foreach ($this->cuttingSpeedsData as $cuttingSpeed) {
			if ($cuttingSpeed->material_id == $materialId && $cuttingSpeed->thickness == $thickness) {
				return $cuttingSpeed->speed;
			}
		}
		return null;
	}

	private function getSetting($key)
	{
		if ($this->settingsData === null) $this->settingsData = $this->readCsv($this->dataPath . self::SETTINGS_CSV);
		foreach ($this->settingsData as $setting) {
			if ($setting->key == $key) return $setting->value;
		}
		return null;
	}

	public function getManipulationSpeed()
	{
		return (int)$this->getSetting('manipulation_speed');
	}

	public function getManipulationStartEndDistance()
	{
		return (int)$this->getSetting('manipulation_start_end_distance');
	}

	public function getAverageDistanceBetweenFeatures()
	{
		return (int)$this->getSetting('average_distance_between_features');
	}
}