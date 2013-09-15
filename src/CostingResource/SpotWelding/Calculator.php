<?php namespace CostingResource\SpotWelding;

use CostingResource\CalculatorInterface;

class Calculator implements CalculatorInterface {
	
	private $data;

	public function __construct($data = null)
	{
		if ($data === null) $data = new CsvData();
		$this->data = $data;
	}
	
	public function validate(array $data)
	{
		// @TODO: implement this 
		return true;
	}

	public function calculate(array $data)
	{
		$isRobotic = $data['is_robotic'];
		$numberOfWelds = $data['number_of_welds'];
		$numberOfConstructionWelds = $data['number_of_construction_welds'];
		
		// optional
		$country = $this->data->findCountry(isset($data['country_id']) ? $data['country_id'] : 1);
		
		//$machine = $this->data->findMachine(isset($data['machine_id']) ? $data['machine_id'] : 1);
		$machine = $this->data->findMachine($isRobotic ? 2 : 1);
		
		$loadQuantities = isset($data['load_quantities']) ? $data['load_quantities'] : array(0, 0, 0);
		$unloadQuantities = isset($data['unload_quantities']) ? $data['unload_quantities'] : array(0, 0, 0);

		$settings = $this->data->getSettings();

		$loadUnloadTime = $this->calculateLoadUnloadTime($loadQuantities, $unloadQuantities);

		if ($isRobotic) {

			$weldTime =
				($numberOfConstructionWelds * $settings->robot_constructional) + 
				(($numberOfWelds - $numberOfConstructionWelds) * $settings->robot_stitching);
			
			$robotAddrInOut = $settings->robot_addr_in + $settings->robot_addr_out;
			$controllingCycle = max(array($loadUnloadTime, $weldTime + $robotAddrInOut));
			$totalTime = $controllingCycle;
		} else {

			$weldTime = 
				(($numberOfConstructionWelds * $settings->manual_constructional) + 
				($numberOfWelds - $numberOfConstructionWelds) * $settings->manual_stitching);
			
			$robotAddrInOut = null;
			$controllingCycle = null;
			$totalTime = $loadUnloadTime + $weldTime;
		}

		$cycleTime = $totalTime / 60.0;

		$labourCost = ($country->labour_cost_rate / 60.0) * $cycleTime;
		$machineCost = ($machine->rate / 60.0) * $cycleTime;
		$overheads = ($labourCost + $machineCost) * (1.0 + $country->overheads);
		$profit = ($labourCost + $machineCost) * (1.0 + $country->profit);
		$price = $labourCost + $machineCost + $overheads + $profit;

		return [
			'result' => [
				'loading_unloading' => $loadUnloadTime,
				'robot_addr_in_out' => $robotAddrInOut,
				'weld_time' => $weldTime,
				'controlling_cycle' => $controllingCycle,
				'total_time' => $totalTime,
				'cycle_time' => $cycleTime,
				'machine' => [
					'id' => $machine->id,
					'name' => $machine->name,
					'manufacturer' => $machine->manufacturer,
					'size' => $machine->size,
					'image' => $machine->image,
					'video' => $machine->video,
					'rate' => $machine->rate,
				],
				'country' => [
					'id' => $country->id,
					'name' => $country->name,
					'labour_rate' => $country->labour_cost_rate,
				],
				'costs' => [
					'labour' => $labourCost,
					'machine' => $machineCost,
					'overheads' => $overheads, 
					'profit' => $profit, 
					'price' => $price, 
				],
			],
		];
	}

	public function calculateLoadUnloadTime($loadQuantities, $unloadQuantities)
	{
		$loadTime0 = $this->data->getLoadTimesForWeight(0);
		$loadTime1 = $this->data->getLoadTimesForWeight(1);
		$loadTime2 = $this->data->getLoadTimesForWeight(8);

		$loadTime = $loadQuantities[0] * $loadTime0->load + $loadQuantities[1] * $loadTime1->load + $loadQuantities[2] * $loadTime2->load;
		$unloadTime = $unloadQuantities[0] * $loadTime0->unload + $unloadQuantities[1] * $loadTime1->unload + $unloadQuantities[2] * $loadTime2->unload;

		return $loadTime + $unloadTime;
	}

	public function getCalculatorData()
	{
		return (object)array(
			'machines' => $this->data->getMachines(),
			'countries' => $this->data->getCountries(),
		);
	}
}