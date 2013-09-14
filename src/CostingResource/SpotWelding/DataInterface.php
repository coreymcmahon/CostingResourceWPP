<?php namespace CostingResource\SpotWelding;

interface DataInterface {

	public function getMachines();
	
	public function getCountries();
	
	public function getLoadTimes();
	
	public function getSettings();
	
	public function getLoadTimesForWeight($weight);
	
}