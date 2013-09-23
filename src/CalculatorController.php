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
		return $this->calculator->validate($this->calculator->getPostData($_POST));
	}

	public function postCalculate()
	{
		return $this->calculator->calculate($this->calculator->getPostData($_POST));
	}

}