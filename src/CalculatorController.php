<?php 

class CalculatorController {
	
	private $calculator;

	public function __construct($calculator)
	{
		$this->calculator = $calculator;
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