<?php namespace CostingResource\SpotWelding;

class CalculatorTest extends \TestCase {

	public function setUp()
	{
		parent::setUp();
		$this->calculator = new Calculator();
	}

	public function tearDown()
	{
		\Mockery::close();
		parent::tearDown();
	}

	public function testTests()
	{
		$this->assertTrue(true);
	}

	public function testCalculateLoadUnloadTime()
	{
		$loadQuantities = array(10, 22, 4);
		$unloadQuantities = array(22, 44, 12);

		$mock = \Mockery::mock('CostingResource\SpotWelding\DataInterface');
		
		$mock->shouldReceive('getLoadTimesForWeight')
			->with(0)
			->andReturn((object) array('load' => 3.6, 'unload' => 2.4));

		$mock->shouldReceive('getLoadTimesForWeight')
			->with(1)
			->andReturn((object) array('load' => 6.0, 'unload' => 4.2));

		$mock->shouldReceive('getLoadTimesForWeight')
			->with(8)
			->andReturn((object) array('load' => 8.4, 'unload' => 6.6));

		$calculator = new Calculator($mock);

		$result = $calculator->calculateLoadUnloadTime($loadQuantities, $unloadQuantities);

		$this->assertEquals($result, 518.4);
	}

	public function testCalculateReturnsCorrectlyFormattedArray()
	{
		$data = array (
			'is_robotic' => true,
			'number_of_welds' => 12,
			'number_of_construction_welds' => 15,
			'load_quantities' => '3,1,0',
			'unload_quantities' => '0,0,1',
			//'machine_id' => 0,
		);

		$result = $this->calculator->calculate($data);

		$this->assertArrayHasKey('result', $result);
		// root level attributes
		$this->assertArrayHasKey('loading_unloading', $result['result']);
		$this->assertArrayHasKey('robot_addr_in_out', $result['result']);
		$this->assertArrayHasKey('weld_time', $result['result']);
		$this->assertArrayHasKey('controlling_cycle', $result['result']);
		$this->assertArrayHasKey('total_time', $result['result']);
		$this->assertArrayHasKey('cycle_time', $result['result']);
		$this->assertArrayHasKey('machine', $result['result']);
		$this->assertArrayHasKey('country', $result['result']);
		$this->assertArrayHasKey('costs', $result['result']);
		// machine attributes
		$this->assertArrayHasKey('id', $result['result']['machine']);
		$this->assertArrayHasKey('name', $result['result']['machine']);
		$this->assertArrayHasKey('manufacturer', $result['result']['machine']);
		$this->assertArrayHasKey('size', $result['result']['machine']);
		$this->assertArrayHasKey('image', $result['result']['machine']);
		$this->assertArrayHasKey('video', $result['result']['machine']);
		$this->assertArrayHasKey('rate', $result['result']['machine']);
		// country attributes
		$this->assertArrayHasKey('id', $result['result']['country']);
		$this->assertArrayHasKey('name', $result['result']['country']);
		$this->assertArrayHasKey('labour_rate', $result['result']['country']);
		// cost attributes
		$this->assertArrayHasKey('labour', $result['result']['costs']);
		$this->assertArrayHasKey('machine', $result['result']['costs']);
		$this->assertArrayHasKey('overheads', $result['result']['costs']);
		$this->assertArrayHasKey('profit', $result['result']['costs']);
		$this->assertArrayHasKey('price', $result['result']['costs']);
	}

	public function testCalculateReturnsCorrectValuesForRoboticWelding()
	{
		$data = array (
			'is_robotic' => true,
			'number_of_welds' => 12,
			'number_of_construction_welds' => 15,
			'load_quantities' => '3,1,0',
			'unload_quantities' => '0,0,1',
			//'machine_id' => 0,
		);

		$result = $this->calculator->calculate($data);

		// root level attributes
		$this->assertEquals(23.40, $result['result']['loading_unloading']);
		$this->assertEquals(4.80,  $result['result']['robot_addr_in_out']);
		$this->assertEquals(39.60, $result['result']['weld_time']);
		$this->assertEquals(44.40, $result['result']['controlling_cycle']);
		$this->assertEquals(44.40, $result['result']['total_time']);
		$this->assertEquals(0.74,  $result['result']['cycle_time']);
		// machine attributes
		$this->assertEquals(2, $result['result']['machine']['id']);
		$this->assertEquals('robotic spot welder', strtolower($result['result']['machine']['name']));
		$this->assertEquals('Motorman', $result['result']['machine']['manufacturer']);
		$this->assertEquals(1600, $result['result']['machine']['size']);
		$this->assertEquals('robotspotwelder.jpg', $result['result']['machine']['image']); // @TODO: store image and display it here
		$this->assertEquals('-vCxkphKb_Y', $result['result']['machine']['video']);
		$this->assertEquals(91.00, $result['result']['machine']['rate']);
		// country attributes
		$this->assertEquals(1, $result['result']['country']['id']);
		$this->assertEquals('UK', $result['result']['country']['name']);
		$this->assertEquals(20.00, $result['result']['country']['labour_rate']);
		// cost attributes
		$this->assertEquals(0.25, $result['result']['costs']['labour']);
		$this->assertEquals(1.12, $result['result']['costs']['machine']);
		$this->assertEquals(1.99, $result['result']['costs']['overheads']);
		$this->assertEquals(1.67, $result['result']['costs']['profit']);
		$this->assertEquals(5.02, $result['result']['costs']['price']);
	}

	public function testCalculateReturnsCorrectValuesForManualWelding()
	{
		$data = array (
			'is_robotic' => false,
			'number_of_welds' => 12,
			'number_of_construction_welds' => 15,
			'load_quantities' => '3,1,0',
			'unload_quantities' =>' 0,0,1',
			//'machine_id' => 0,
		);

		$result = $this->calculator->calculate($data);

		// root level attributes
		$this->assertEquals(null, $result['result']['robot_addr_in_out']);
		$this->assertEquals(null, $result['result']['controlling_cycle']);
		$this->assertEquals(47.70, $result['result']['weld_time']);
		$this->assertEquals(71.10, $result['result']['total_time']);
		$this->assertEquals(1.19,  $result['result']['cycle_time']);
		// machine attributes
		$this->assertEquals(1, $result['result']['machine']['id']);
		$this->assertEquals('manual spot welder', strtolower($result['result']['machine']['name']));
		$this->assertEquals('Esab', $result['result']['machine']['manufacturer']);
		$this->assertEquals(400, $result['result']['machine']['size']);
		$this->assertEquals('manualspotwelder.jpg', $result['result']['machine']['image']); // @TODO: store image and display it here
		$this->assertEquals('_kdnEBaAI78', $result['result']['machine']['video']);
		$this->assertEquals(32.0, $result['result']['machine']['rate']);
		// country attributes same as previous test.
		// cost attributes
		$this->assertEquals(0.40, $result['result']['costs']['labour']);
		$this->assertEquals(0.63, $result['result']['costs']['machine']);
		$this->assertEquals(1.49, $result['result']['costs']['overheads']);
		$this->assertEquals(1.25, $result['result']['costs']['profit']);
		$this->assertEquals(3.77, $result['result']['costs']['price']);
	}

	public function testGetCalculatorDataReturnsCorrectlyFormattedObject()
	{
		$result = $this->calculator->getCalculatorData();

		$this->assertObjectHasAttribute('countries', $result);
		$this->assertObjectHasAttribute('machines', $result);
	}

	public function testGetCalculatorDataReturnsCountries()
	{
		$result = $this->calculator->getCalculatorData();

		$this->assertObjectHasAttribute('countries', $result);
		$this->assertInternalType('array', $result->countries);
		$this->assertObjectHasAttribute('id', $result->countries[0]);
		$this->assertObjectHasAttribute('name', $result->countries[0]);
		$this->assertObjectHasAttribute('labour_cost_rate', $result->countries[0]);
		$this->assertObjectHasAttribute('overheads', $result->countries[0]);
		$this->assertObjectHasAttribute('profit', $result->countries[0]);
	}

	public function testGetCalculatorDataReturnsMachines()
	{
		$result = $this->calculator->getCalculatorData();

		$this->assertObjectHasAttribute('machines', $result);
		$this->assertInternalType('array', $result->machines);
		$this->assertObjectHasAttribute('id', $result->machines[0]);
		$this->assertObjectHasAttribute('name', $result->machines[0]);
		$this->assertObjectHasAttribute('manufacturer', $result->machines[0]);
		$this->assertObjectHasAttribute('size', $result->machines[0]);
		$this->assertObjectHasAttribute('image', $result->machines[0]);
		$this->assertObjectHasAttribute('video', $result->machines[0]);
		$this->assertObjectHasAttribute('rate', $result->machines[0]);
	}

}