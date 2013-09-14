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
			'load_quantities' => array(3, 1 ,0),
			'unload_quantities' => array(0, 0, 1),
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
			'load_quantities' => array(3, 1 ,0),
			'unload_quantities' => array(0, 0, 1),
			//'machine_id' => 0,
		);

		$result = $this->calculator->calculate($data);

		// root level attributes
		$this->assertEquals(23.4,  $result['result']['loading_unloading']);
		$this->assertEquals(4.8,   $result['result']['robot_addr_in_out']);
		$this->assertEquals(39.6,  $result['result']['weld_time']);
		$this->assertEquals(44.4,  $result['result']['controlling_cycle']);
		$this->assertEquals(44.4, $result['result']['total_time']);
		$this->assertEquals(0.74,  $result['result']['cycle_time']);
		// machine attributes
		$this->assertEquals(0, $result['result']['machine']['id']);
		$this->assertEquals('Robotic Spot Welder', $result['result']['machine']['name']);
		$this->assertEquals('Motorman', $result['result']['machine']['manufacturer']);
		$this->assertEquals(1600, $result['result']['machine']['size']);
		$this->assertEquals('', $result['result']['machine']['image']); // @TODO: store image and display it here
		$this->assertEquals('http://www.youtube.com/watch?v=_kdnEBaAI78', $result['result']['machine']['video']);
		$this->assertEquals(91.0, $result['result']['machine']['rate']);
		// country attributes
		$this->assertEquals(0, $result['result']['country']['id']);
		$this->assertEquals('UK', $result['result']['country']['name']);
		$this->assertEquals(20.0, $result['result']['country']['labour_rate']);
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
			'load_quantities' => array(3, 1 ,0),
			'unload_quantities' => array(0, 0, 1),
			//'machine_id' => 0,
		);

		$result = $this->calculator->calculate($data);

		// root level attributes
		$this->assertEquals(null, $result['result']['robot_addr_in_out']);
		$this->assertEquals(null, $result['result']['controlling_cycle']);
		$this->assertEquals(47.7,  $result['result']['weld_time']);
		$this->assertEquals(71.10, $result['result']['total_time']);
		$this->assertEquals(1.19, $result['result']['cycle_time']);
		// machine attributes same as previous test.
		// country attributes same as previous test.
		// cost attributes
		$this->assertEquals(0.40, $result['result']['costs']['labour']);
		$this->assertEquals(1.80, $result['result']['costs']['machine']);
		$this->assertEquals(3.18, $result['result']['costs']['overheads']);
		$this->assertEquals(2.67, $result['result']['costs']['profit']);
		$this->assertEquals(8.05, $result['result']['costs']['price']);
	}

}