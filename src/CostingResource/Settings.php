<?php namespace CostingResource;

class Settings {
	
	public static $CUTTING_CALCULATOR_NAMESPACE = 'cutting';
	public static $SPOT_WELDING_CALCULATOR_NAMESPACE = 'spot_welding';

	public static function getNamespaces()
	{
		return array(
			self::$CUTTING_CALCULATOR_NAMESPACE => 'Laser Cutting Calculator',
			self::$SPOT_WELDING_CALCULATOR_NAMESPACE => 'Spot Welding Calculator',
		);
	}
}