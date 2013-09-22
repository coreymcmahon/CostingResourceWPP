<?php namespace CostingResource\Cutting;

class CsvDataTest extends \TestCase {
	private $csvData;

	protected function setUp()
	{
		$dataPath = __DIR__ . '/../../data/cutting/';

		$this->csvData = new CsvData(array(
			'countries' => file_get_contents(realpath($dataPath . 'countries.csv')),
			'cutting_speeds' => file_get_contents(realpath($dataPath . 'cutting_speeds.csv')),
			'machines' => file_get_contents(realpath($dataPath . 'machines.csv')),
			'materials' => file_get_contents(realpath($dataPath . 'materials.csv')),
			'settings' => file_get_contents(realpath($dataPath . 'settings.csv')),
			'start_holes' => file_get_contents(realpath($dataPath . 'start_holes.csv')),
		));
	}

	public function testParseValueParsesInteger()
	{
		$this->assertEquals(1, $this->csvData->parseValue('1'));
	}

	public function testParseValueParsesFloat()
	{
		$this->assertEquals(1.0, $this->csvData->parseValue('1.0'));
		$this->assertEquals(3.16, $this->csvData->parseValue('3.16'));
		$this->assertEquals(0.0, $this->csvData->parseValue('0.0')); // @TODO: change assertion to check type
	}

	public function testParseValueParsesString()
	{
		$this->assertEquals('foo', $this->csvData->parseValue('"foo"'));
		$this->assertEquals('bar', $this->csvData->parseValue('"bar"'));
		$this->assertEquals('', $this->csvData->parseValue('""'));
	}

	public function testParseValueParsesMixtureAsString()
	{
		$this->assertEquals('1.0f', $this->csvData->parseValue('"1.0f"'));
	}

	public function testGetMaterials()
	{        
		$expected = array();
		$expected[0] = new \stdClass;
		$expected[0]->id = 1;
		$expected[0]->name = 'Steel';
		$expected[1] = new \stdClass;
		$expected[1]->id = 2;
		$expected[1]->name = 'Aluminium';
		$expected[2] = new \stdClass;
		$expected[2]->id = 3;
		$expected[2]->name = 'Titanium';

		$actual = $this->csvData->getMaterials();

		$this->assertEquals($expected, $actual);
	}

	public function testGetMachines()
	{
		$expected = $this->csvData->getMachines();

		$actual = array();
		$actual[0] = new \stdClass;
		$actual[0]->id =  1;
		$actual[0]->name = 'Small laser';
		$actual[0]->manufacturer = 'Trumpf';
		$actual[0]->size = '1m x 1m bed';
		$actual[0]->image = '/wp-content/plugins/CM_LaserCuttingCalc/assets/images/trumpf-laser.jpg';
		$actual[0]->youtube = 'c89Zx7YqqVc';
		$actual[0]->cost_per_hour = 60;
		$actual[1] = new \stdClass;
		$actual[1]->id = 2;
		$actual[1]->name = 'Large laser';
		$actual[1]->manufacturer = 'Amada';
		$actual[1]->size = '2m x 1m bed';
		$actual[1]->image = '/wp-content/plugins/CM_LaserCuttingCalc/assets/images/amada-laser.jpg';
		$actual[1]->youtube = 'K-k6uEEpnxU';
		$actual[1]->cost_per_hour = 85;

		$this->assertEquals($expected, $actual);
	}

	public function testGetCountries()
	{
		$expected = array();
		$expected[0] = new \stdClass;
		$expected[0]->id = 1;
		$expected[0]->name = 'UK';
		$expected[0]->labour_cost_rate = 20;
		$expected[0]->overheads = 0.3;
		$expected[0]->profit = 0.22;
		
		$expected[1] = new \stdClass;
		$expected[1]->id = 2;
		$expected[1]->name = 'China';
		$expected[1]->labour_cost_rate = 6;
		$expected[1]->overheads = 0.15;
		$expected[1]->profit = 0.17;

		$actual = $this->csvData->getCountries();

		$this->assertEquals($expected, $actual);
	}

	public function testGetMaterial()
	{
		$id = 2;
		
		$expected = new \stdClass;
		$expected->id = 2;
		$expected->name = 'Aluminium';

		$actual = $this->csvData->getMaterial($id);

		$this->assertEquals($expected, $actual);
	}
	
	public function testGetMachine()
	{
		$id = 2;

		$expected = new \stdClass;
		$expected->id = 2;
		$expected->name = 'Large laser';
		$expected->manufacturer = 'Amada';
		$expected->size = '2m x 1m bed';
		$expected->image = '/wp-content/plugins/CM_LaserCuttingCalc/assets/images/amada-laser.jpg';
		$expected->youtube = 'K-k6uEEpnxU';
		$expected->cost_per_hour = 85;

		$actual = $this->csvData->getMachine($id);

		$this->assertEquals($expected, $actual);
	}

	public function testGetCountry()
	{
		$id = 2;

		$expected = new \stdClass;
		$expected->id = 2;
		$expected->name = 'China';
		$expected->labour_cost_rate = 6;
		$expected->overheads = 0.15;
		$expected->profit = 0.17;
		
		$actual = $this->csvData->getCountry($id);
	
		$this->assertEquals($expected, $actual);
	}

	public function testGetLastCuttingSpeedEntryForMaterial()
	{
		$id = 2;

		$this->assertEquals(5, $this->csvData->getLastCuttingSpeedEntryForMaterial($id)->thickness);
	}

	public function testGetStartHoleByMaterialAndThickness()
	{
		$materialId = 2;
		$thickness = 4;

		$this->assertEquals(2.4, $this->csvData->getStartHoleByMaterialAndThickness($materialId, $thickness));
	}

	public function testGetStartHoleByMaterialAndThicknessForSteel()
	{
		$materialId = 1;
		$thickness = 5;

		$this->assertEquals(1.76, $this->csvData->getStartHoleByMaterialAndThickness($materialId, $thickness));
	}

	public function testGetCuttingSpeedByMaterialAndThickness()
	{
		$materialId = 2;
		$thickness = 4;

		$this->assertEquals(490, $this->csvData->getCuttingSpeedByMaterialAndThickness($materialId, $thickness));
	}

	public function testCuttingSpeedByMaterialAndThicknessForSteel()
	{
		$materialId = 1;
		$thickness = 5;
		$this->assertEquals(600, $this->csvData->getCuttingSpeedByMaterialAndThickness($materialId, $thickness));
	}

	public function testGetManipulationSpeed()
	{
		$this->assertEquals(5000, $this->csvData->getManipulationSpeed());
	}

	public function testGetManipulationStartEndDistance()
	{
		$this->assertEquals(100, $this->csvData->getManipulationStartEndDistance());
	}

	public function testGetAverageDistanceBetweenFeatures()
	{
		$this->assertEquals(120, $this->csvData->getAverageDistanceBetweenFeatures());
	}
}