<?php namespace CostingResource\SpotWelding;

class CsvDataTest extends \TestCase {

	public function setUp()
	{
		$dataPath = __DIR__ . '/../../data/spot_welding/';

		$this->data = new CsvData(array(
			'countries' => file_get_contents(realpath($dataPath . 'countries.csv')),
			'machines' => file_get_contents(realpath($dataPath . 'machines.csv')),
			'load_times' => file_get_contents(realpath($dataPath . 'load_times.csv')),
			'settings' => file_get_contents(realpath($dataPath . 'settings.csv')),
		));
	}

	public function testTests()
	{
		$this->assertTrue(true);
	}

	public function testReadCsv()
	{
		$result = $this->data->readCsv(realpath(__DIR__ . '/../../data/test.csv'));
		$this->assertEquals($result[0]->id, 1);
		$this->assertEquals($result[0]->name, 'Something');
		$this->assertEquals($result[1]->id, 2);
		$this->assertEquals($result[1]->name, 'Something else');
	}

	public function testGetCountries()
	{
		$countries = $this->data->getCountries();

		$this->assertEquals($countries[1]->name, 'China');
		$this->assertEquals($countries[1]->labour_cost_rate, 6);
		$this->assertEquals($countries[1]->overheads, 0.27);
		$this->assertEquals($countries[1]->profit, 0.17);
	}

	public function testGetLoadTimes()
	{
		$loadTimes = $this->data->getLoadTimes();
		$this->assertEquals($loadTimes[1]->weight_low, 1);
		$this->assertEquals($loadTimes[1]->weight_high, 8);
	}

	public function testGetLoadTimesForWeight()
	{
		$loadTime = $this->data->getLoadTimesForWeight(1);
		$this->assertEquals($loadTime->load, 6);
		$this->assertEquals($loadTime->unload, 4.2);

		$loadTime = $this->data->getLoadTimesForWeight(9);
		$this->assertEquals($loadTime->load, 8.4);
		$this->assertEquals($loadTime->unload, 6.6);
	}

	public function testGetLoadTimesForWeightFailsOutsideOfRange()
	{
		$loadTime = $this->data->getLoadTimesForWeight(15);
		$this->assertEquals($loadTime, null);
	}

	public function testGetSettings()
	{
		$settings = $this->data->getSettings();
		
		$this->assertEquals($settings->manual_constructional, 3.6);
		$this->assertEquals($settings->manual_stitching, 2.1);
		$this->assertEquals($settings->robot_constructional, 3);
		$this->assertEquals($settings->robot_stitching, 1.8);
		$this->assertEquals($settings->manual_pickup_putdown, 6);
		$this->assertEquals($settings->manual_stamp_part, 12);
		$this->assertEquals($settings->robot_addr_in, 2.4);
		$this->assertEquals($settings->robot_addr_out, 2.4);
	}

	public function testGetMachines()
	{
		$machines = $this->data->getMachines();

		$this->assertEquals(strtolower($machines[1]->name), 'robotic spot welder');
		$this->assertEquals($machines[1]->manufacturer, 'Motorman');
		$this->assertEquals($machines[1]->size, 1600);
		$this->assertEquals($machines[1]->image, 'robotspotwelder.jpg');
		$this->assertEquals($machines[1]->video, '-vCxkphKb_Y');
		$this->assertEquals($machines[1]->rate, 91);
	}

	public function testParseValue()
	{
		$this->assertEquals('Something', $this->data->parseValue('"Something"'));
		$this->assertEquals(10, $this->data->parseValue('10')); // this should assert int
		$this->assertEquals(1.15, $this->data->parseValue('1.15')); // this should assert float
	}
}