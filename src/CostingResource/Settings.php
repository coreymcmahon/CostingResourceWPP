<?php namespace CostingResource;

class Settings {
	
	public static $CUTTING_CALCULATOR_NAMESPACE = 'cutting';
	public static $SPOT_WELDING_CALCULATOR_NAMESPACE = 'spot_welding';

	public static $CUTTING_CALCULATOR_NAME = 'Laser Cutting Calculator';
	public static $SPOT_WELDING_CALCULATOR_NAME = 'Spot Welding Calculator';

	public static function getNamespaces()
	{
		return array(
			self::$CUTTING_CALCULATOR_NAMESPACE => self::$CUTTING_CALCULATOR_NAME,
			self::$SPOT_WELDING_CALCULATOR_NAMESPACE => self::$SPOT_WELDING_CALCULATOR_NAME,
		);
	}

	public static function getCalculatorInstanceFor($namespace)
	{
		if ($namespace === self::$CUTTING_CALCULATOR_NAMESPACE)      return new \CostingResource\Cutting\Calculator();
		if ($namespace === self::$SPOT_WELDING_CALCULATOR_NAMESPACE) return new \CostingResource\SpotWelding\Calculator();
		return null;
	}
}