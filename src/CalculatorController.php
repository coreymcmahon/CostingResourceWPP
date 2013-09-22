<?php 

class CalculatorController {
	
	private $calculator;

	public function __construct($calculator)
	{
		$this->calculator = $calculator;
	}

	public function getIndex()
	{
		$namespace = (isset($_REQUEST['namespace']) ? $_REQUEST['namespace'] : 'cutting');
		
		return new \CalculatorView('index', array(
			'namespace' => $namespace,
			'calculatorData' => $this->calculator->getCalculatorData(),
		));
	}

	public function getCalculatorData()
	{
		return $this->calculator->getCalculatorData();
	}

	public function postValidate()
	{
		return $this->calculator->validate($this->getData());
	}

	public function postCalculate()
	{
		return $this->calculator->calculate($this->getData());
	}

	private function post($key, $default = null)
	{
		if(isset($_POST[$key])) return $_POST[$key];
		return $default;
	}

	private function getData()
	{
		// @TODO: this will need to be moved to the calculator object
		return array(
			'material_id' => $this->post('material_id'),
			'thickness' => $this->post('thickness'),
			'length' => $this->post('length'),
			'holes' => $this->post('holes'),
			'machine_id' => $this->post('machine_id'),
			'country_id' => $this->post('country_id'),
			'cutting_speed' => $this->post('cutting_speed'),
			'manipulation_speed' => $this->post('manipulation_speed'),
		);
	}

}