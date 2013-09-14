<?php namespace CostingResource\SpotWelding;

class CalculatorTest extends \TestCase {

	public function setUp()
	{
		$this->calculator = new Calculator();
	}

	public function testTests()
	{
		$this->assertTrue(true);
	}

	public function testCalculateReturnsCorrectlyFormattedArray()
	{
		$data = array (
			'is_robotic' => true,
			'number_of_welds' => 12,
			'number_of_construction_welds' => 15,
			'load_weights' => array(3, 1 ,0),
			'unload_weights' => array(0, 0, 1),
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
			'load_weights' => array(3, 1 ,0),
			'unload_weights' => array(0, 0, 1),
			//'machine_id' => 0,
		);

		$result = $this->calculator->calculate($data);

		// root level attributes
		$this->assertEquals($result['result']['loading_unloading'], 23.4);
		$this->assertEquals($result['result']['robot_addr_in_out'], 4.8);
		$this->assertEquals($result['result']['weld_time'], 32.7);
		$this->assertEquals($result['result']['controlling_cycle'], 37.5);
		$this->assertEquals($result['result']['total_time'], 37.50);
		$this->assertEquals($result['result']['cycle_time'], 0.63);
		// machine attributes
		$this->assertEquals($result['result']['machine']['id'], 0);
		$this->assertEquals($result['result']['machine']['name'], 'Robotic Spot Welder');
		$this->assertEquals($result['result']['machine']['manufacturer'], 'Motorman');
		$this->assertEquals($result['result']['machine']['size'], 1600);
		$this->assertEquals($result['result']['machine']['image'], ''); // @TODO: store image and display it here
		$this->assertEquals($result['result']['machine']['video'], 'http://www.youtube.com/watch?v=_kdnEBaAI78');
		$this->assertEquals($result['result']['machine']['rate'], 91.0);
		// country attributes
		$this->assertEquals($result['result']['country']['id'], 0);
		$this->assertEquals($result['result']['country']['name'], 'UK');
		$this->assertEquals($result['result']['country']['labour_rate'], 20.0);
		// cost attributes
		$this->assertEquals($result['result']['costs']['labour'], 0.20);
		$this->assertEquals($result['result']['costs']['machine'], 0.95);
		$this->assertEquals($result['result']['costs']['overheads'], 1.68);
		$this->assertEquals($result['result']['costs']['profit'], 1.41);
		$this->assertEquals($result['result']['costs']['price'], 4.24);
	}

	public function testCalculateReturnsCorrectValuesForManualWelding()
	{
		$data = array (
			'is_robotic' => false,
			'number_of_welds' => 12,
			'number_of_construction_welds' => 15,
			'load_weights' => array(3, 1 ,0),
			'unload_weights' => array(0, 0, 1),
			//'machine_id' => 0,
		);

		$result = $this->calculator->calculate($data);

		// root level attributes
		$this->assertEquals($result['result']['robot_addr_in_out'], 0.0); // 0 or null?
		$this->assertEquals($result['result']['controlling_cycle'], 0.0); // " "
		$this->assertEquals($result['result']['total_time'], 51.0);
		$this->assertEquals($result['result']['cycle_time'], 0.85);
		// machine attributes same as previous test.
		// country attributes same as previous test.
		// cost attributes
		$this->assertEquals($result['result']['costs']['labour'], 0.28);
		$this->assertEquals($result['result']['costs']['machine'], 1.29);
		$this->assertEquals($result['result']['costs']['overheads'], 2.28);
		$this->assertEquals($result['result']['costs']['profit'], 1.92);
		$this->assertEquals($result['result']['costs']['price'], 5.77);
	}

}