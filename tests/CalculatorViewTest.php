<?php 

class CalculatorViewTest extends TestCase {

	public function testRender()
	{
		$test = 'Hello World!';
		$expectedOutput = "<!DOCTYPE html><html><body>${test}</body></html>";

		$view = new CalculatorView('index', array('test' => $test), __DIR__ . '/templates/');

		$this->assertEquals($expectedOutput, $view->render());
	}

}