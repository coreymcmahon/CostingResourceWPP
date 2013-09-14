<?php namespace CostingResource\Cutting;

class CalculatorTest extends \TestCase {

	private $calculator;

	protected function setUp()
	{
		$dataPath = __DIR__ . '/../../data/cutting/';

		$this->calculator = new Calculator(
			// Ideally this would be mocked. Using the real class serves the purpose though,
			// as it allows us to write integration-style tests.
			new CsvData(array(
				'countries' => file_get_contents(realpath($dataPath . 'countries.csv')),
				'cutting_speeds' => file_get_contents(realpath($dataPath . 'cutting_speeds.csv')),
				'machines' => file_get_contents(realpath($dataPath . 'machines.csv')),
				'materials' => file_get_contents(realpath($dataPath . 'materials.csv')),
				'settings' => file_get_contents(realpath($dataPath . 'settings.csv')),
				'start_holes' => file_get_contents(realpath($dataPath . 'start_holes.csv')),
			))
		);
	}

	public function testGetCuttingSpeedByMaterialAndThicknessRoundsUpCorrectly()
	{
		$this->assertEquals(700, $this->calculator->getCuttingSpeedByMaterialAndThickness(1, 3.67));
		$this->assertEquals(700, $this->calculator->getCuttingSpeedByMaterialAndThickness(1, 4));
	}

	public function testGetCuttingSpeedByMaterialAndThicknessFailsOutsideOfRange()
	{
		$this->assertEquals(null, $this->calculator->getCuttingSpeedByMaterialAndThickness(1, 6.1));
	}

	public function testGetCuttingSpeedByMaterialAndThicknessAllowsOverride()
	{
		$override = 9876;

		$this->assertEquals($override, $this->calculator->getCuttingSpeedByMaterialAndThickness(1, 2, $override));
	}

	public function testGetStartHoleByMaterialAndThicknessRoundsUpCorrectly()
	{
		$this->assertEquals(2.18, $this->calculator->getStartHoleByMaterialAndThickness(2, 2.1));
		$this->assertEquals(2.18, $this->calculator->getStartHoleByMaterialAndThickness(2, 3));
	}

	public function testGetStartHoleByMaterialAndThicknessFailsOutsideOfRange()
	{
		$this->assertEquals(null, $this->calculator->getStartHoleByMaterialAndThickness(2, 7));
	}    

	public function testGetMaterials()
	{
		$materials = $this->calculator->getMaterials();
		$this->assertEquals($materials[0]->id, 1);
		$this->assertEquals($materials[0]->name, 'Steel');
	}

	public function testGetCountries()
	{
		$countries = $this->calculator->getCountries();
		$this->assertEquals($countries[1]->id, 2);
		$this->assertEquals($countries[1]->name, 'China');
	}

	public function testGetMachines()
	{
		$machines = $this->calculator->getMachines();
		$this->assertEquals($machines[0]->id, 1);
		$this->assertEquals($machines[0]->manufacturer, 'Trumpf');
	}

	public function testGetStartHoleByMaterialAndThickness()
	{
		$materialId = 3;
		$thickness = 4;
		$this->assertEquals(3.59, $this->calculator->getStartHoleByMaterialAndThickness($materialId, $thickness));
	}

	public function testCalculate() // probably need a few of these...
	{
		$data = array(
			'material_id' => 1,
			'thickness' => 5,
			'length' => 550,
			'holes' => 17,
			'machine_id' => 1,
			'country_id' => 1,
			// 'cuttingSpeed' => '',
			// 'manipulationSpeed' => '',
		);

		$result = $this->calculator->calculate($data);

		$this->assertEquals(600, $result['cutting_speed']);
		$this->assertEquals(5000, $result['manipulation_speed']);
		$this->assertEquals(1.42, $result['cutting_time']);
		$this->assertEquals(0.43, $result['manipulation_time']);
		$this->assertEquals(1.84, $result['total_time']);
	}

	public function testCalculateReturnsNullForBadInput()
	{
		$data = array(
			'material_id' => 1,
			'thickness' => 5,
			'length' => 550,
			'holes' => 0,
			// 'machineId' => 0,
			// 'country_id' => 0,
			// 'cutting_speed' => '',
			// 'manipulation_speed' => '',
		);
		$this->assertEquals(null, $this->calculator->calculate($data));
	}

	public function testCalculateAllowsCuttingSpeedOverride()
	{
		$cuttingSpeedOverride = 1000;
		$data = array(
			'material_id' => 1,
			'thickness' => 5,
			'length' => 550,
			'holes' => 17,
			'machineId' => 1,
			'country_id' => 1,
			'cutting_speed' => $cuttingSpeedOverride,
			// 'manipulation_speed' => '',
		);

		$result = $this->calculator->calculate($data);
		$this->assertEquals($cuttingSpeedOverride, $result['cutting_speed']);
	}

	public function testCalculateAllowsManipulationSpeedOverride()
	{
		$manipulationSpeedOverride = 1000;
		$data = array(
			'material_id' => 1,
			'thickness' => 5,
			'length' => 550,
			'holes' => 17,
			'machineId' => 1,
			'country_id' => 1,
			'cutting_speed' => null,
			'manipulation_speed' => $manipulationSpeedOverride,
		);

		$result = $this->calculator->calculate($data);
		$this->assertEquals($manipulationSpeedOverride, $result['manipulation_speed']);
	}
}