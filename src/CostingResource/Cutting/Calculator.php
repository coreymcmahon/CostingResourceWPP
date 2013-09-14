<?php namespace CostingResource\Cutting;

use CostingResource\CalculatorInterface;

class Calculator implements CalculatorInterface {
	
	static $instance;
	private $data;

	public function __construct($data = null)
	{
		if ($data === null) $data = new CsvData();
		$this->data = $data;
	}

	public function getMaterials()
	{
		return $this->data->getMaterials();
	}

	public function getMachines()
	{
		return $this->data->getMachines();
	}

	public function getCountries()
	{
		return $this->data->getCountries();
	}

	public function getMachinesForSelect()
	{
		$machines = $this->data->getMachines();
		$machinesForSelect = array();
		foreach ($machines as $machine) {
			$machinesForSelect[$machine->id] = $machine->name;
		}
		return $machinesForSelect;
	}

	public function getCountriesForSelect()
	{
		$countries = $this->data->getCountries();
		$countriesForSelect = array();
		foreach ($countries as $country) {
			$countriesForSelect[$country->id] = $country->name;
		}
		return $countriesForSelect;
	}

	public function getCuttingSpeedByMaterialAndThickness($materialId, $thickness, $cuttingSpeed = null)
	{
		if ($cuttingSpeed !== null) return $cuttingSpeed;
		$thickness = ceil($thickness);
		return $this->data->getCuttingSpeedByMaterialAndThickness($materialId, $thickness);
	}
	
	public function getStartHoleByMaterialAndThickness($materialId, $thickness) {
		$thickness = ceil($thickness);
		return $this->data->getStartHoleByMaterialAndThickness($materialId, $thickness);
	}

	public function getMaterial($id)
	{
		return $this->data->getMaterial($id);
	}

	public function getCountry($id)
	{
		return $this->data->getCountry($id);
	}

	public function getMachine($id)
	{
		return $this->data->getMachine($id);
	}

	public function getLastCuttingSpeedEntryForMaterial($materialId)
	{
		return $this->data->getLastCuttingSpeedEntryForMaterial($materialId);
	}

	public function getManipulationSpeed()
	{
		return $this->data->getManipulationSpeed();
	}

	public function getManipulationStartEndDistance()
	{
		return $this->data->getManipulationStartEndDistance();
	}

	public function getAverageDistanceBetweenFeatures()
	{
		return $this->data->getAverageDistanceBetweenFeatures();
	}

	public function calculate(array $data)
	{
		$materialId = $data['material_id']; 
		$thickness = $data['thickness']; 
		$length = $data['length']; 
		$holes = $data['holes']; 
		$machineId = isset($data['machine_id']) ? $data['machine_id'] : null; 
		$countryId = isset($data['country_id']) ? $data['country_id'] : null; 
		$cuttingSpeed = isset($data['cutting_speed']) ? $data['cutting_speed'] : null; 
		$manipulationSpeed = isset($data['manipulation_speed']) ? $data['manipulation_speed'] : null;

		if ($machineId === null) $machineId = 1;
		if ($countryId === null) $countryId = 1;

		$machineObj             = $this->getMachine($machineId);
		$countryObj             = $this->getCountry($countryId);
		$startHole              = $this->getStartHoleByMaterialAndThickness($materialId, $thickness);
		$cuttingSpeed           = $this->getCuttingSpeedByMaterialAndThickness($materialId, $thickness, $cuttingSpeed);
		$manipulationSpeed      = $manipulationSpeed ? $manipulationSpeed : $this->getManipulationSpeed();
		$averageDistanceBetween = $this->getAverageDistanceBetweenFeatures();
		$startEndDistance       = $this->getManipulationStartEndDistance();

		// check we don't have zeros or nulls anywhere
		if ($materialId == 0 || $thickness == 0 || $length == 0 || $holes == 0 || 
			$startHole == 0 || $manipulationSpeed == 0 || $cuttingSpeed == 0 || 
			$averageDistanceBetween == 0 || $startEndDistance == 0)
			return null;

		// Cutting time = (Total length / Cutting speed) + (No of holes x Start Stop Time Used )
		$cuttingTime       = ((float)$length / (float)$cuttingSpeed) + ((float)$holes * (float)$startHole/60.0);

		// Manipulation time = (Inital start distance + (distance between features  x no of features))/manipulation speed
		$manipulationTime = ((float)$startEndDistance + ((float)$averageDistanceBetween * (float)$holes)) / (float)$manipulationSpeed;

		$cycleTime   = (float)$cuttingTime + (float)$manipulationTime;
		$labourCost  = ((float)$countryObj->labour_cost_rate / 60.0) * ((float)$cycleTime);
		$machineCost = ((float)$machineObj->cost_per_hour / 60.0) * ((float)$cycleTime);
		$overheads   = ((float)$labourCost + (float)$machineCost) * (1.0 + (float)$countryObj->overheads); // (Labour cost+Machine cost)*(1+ Overhead percentage from lookup in country table)
		$profit      = ((float)$labourCost + (float)$machineCost) * (1.0 + (float)$countryObj->profit); // (Labour cost+Machine cost)*(1+ Profit percentage from lookup in country table)
		$price       = $labourCost + $machineCost + $overheads + $profit; // (Labour cost + Machine cost + Overheads + Profit)
		
		return array(
			'cutting_speed'      => round($cuttingSpeed, 2),
			'manipulation_speed' => round($manipulationSpeed, 2),
			'cutting_time'       => round($cuttingTime, 2),
			'manipulation_time'  => round($manipulationTime, 2),
			'total_time'         => round($cycleTime, 2),
			'machines'           => $this->getMachinesForSelect(),
			'countries'          => $this->getCountriesForSelect(),

			'machine' => array(
				'id'            => $machineId,
				'name'          => $machineObj->name,
				'manufacturer'  => $machineObj->manufacturer,
				'size'          => $machineObj->size,
				'image'         => $machineObj->image,
				'youtube'       => $machineObj->youtube,
				'cost_per_hour' => round($machineObj->cost_per_hour, 2),
			),

			'costs' => array(
				'country_id'        => $countryId,
				'labour_cost_rate'  => round($countryObj->labour_cost_rate, 2),
				'machine_cost_rate' => round($machineObj->cost_per_hour, 2),
				'cycle_time'        => round($cycleTime, 2),
				'labour_cost'       => round($labourCost, 2),
				'machine_cost'      => round($machineCost, 2),
				'overheads'         => round($overheads, 2),
				'profit'            => round($profit, 2),
				'price'             => round($price, 2),
			),
		);
	}
}