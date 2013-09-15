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
		));
	}

	public function getCalculatorData()
	{
		return $this->calculator->getCalculatorData();
	}

	public function postValidate()
	{
		$data = array(); // @TODO: populate this

		return $this->calculator->validate($data);
	}

	public function postCalculate()
	{
		$data = array(); // @TODO: populate this

		return $this->calculator->calculate($data);
	}

}