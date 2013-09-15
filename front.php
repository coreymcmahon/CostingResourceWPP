<?php 

// require the bootstrap file to include all dependencies
require __DIR__ . '/bootstrap.php';

// build up the request parameters
$method = isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';
$namespace = isset($_REQUEST['namespace']) ? strtolower($_REQUEST['namespace']) : 'cutting';

// create an instance of the relevant calculator implementation
switch ($namespace) {
	case 'cutting':
		$calculator = new CostingResource\Cutting\Calculator();
		break;
	case 'spot_welding':
		$calculator = new CostingResource\SpotWelding\Calculator();
		break;
	default:
		header("HTTP/1.0 400 Bad Request");
		echo json_encode(array());
		$namespace = null;
		break;
}

if ($namespace) {
	$controller = new CalculatorController($calculator);

	// find the method to call and (if valid), run it
	$method = strtolower($method) . ucfirst($action);

	if (is_callable(array($controller, $method))) {

		$result = call_user_func_array(array($controller, $method), array());

		header("HTTP/1.0 200 OK");

		if (get_class($result) === 'CalculatorView') {
			echo $result->render();
		} else {
			echo json_encode($result);
		}

	} else {

		header("HTTP/1.0 400 Bad Request");
		echo json_encode(array());
	}
}