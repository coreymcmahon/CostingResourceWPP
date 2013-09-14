<?php namespace CostingResource;

interface CalculatorInterface {

	public function __construct($data);

	public function calculate(array $data);
}