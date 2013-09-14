<?php namespace CostingResource\SpotWelding;

use CostingResource\CalculatorInterface;

class Calculator implements CalculatorInterface {
	
	private $data;

	public function __construct($data = null)
	{
		if ($data === null) $data = new CsvData();
		$this->data = $data;
	}

	/**
	 * 
	 */
	public function calculate(array $data)
	{
		$isRobotic = $data['is_robotic'];
		$numberOfWelds = $data['number_of_welds'];
		$numberOfConstructionWelds = $data['number_of_construction_welds'];
		// optional
		$loadWeights = isset($data['load_weights']) ? $data['load_weights'] : array();
		$unloadWeights = isset($data['unload_weights']) ? $data['unload_weights'] : array();
		$machine = isset($data['machine_id']) ? $data['machine_id'] : 0;

		return [
			'result' => [
				'loading_unloading' => 0.00,
				'robot_addr_in_out' => 0.00,
				'weld_time' => 0.00,
				'controlling_cycle' => 0.00,
				'total_time' => 0.00,
				'cycle_time' => 0.00,
				'machine' => [
					'id' => 0,
					'name' => '',
					'manufacturer' => '',
					'size' => 0,
					'image' => '',
					'video' => '',
					'rate' => 0.00,
				],
				'country' => [
					'id' => 0,
					'name' => '',
					'labour_rate' => 0.00,
				],
				'costs' => [
					'labour' => 0.00,
					'machine' => 0.00,
					'overheads' => 0.00,
					'profit' => 0.00,
					'price' => 0.00,
				],
			],
		];
	}
}