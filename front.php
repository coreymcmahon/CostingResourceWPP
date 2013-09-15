<?php 

require __DIR__ . '/bootstrap.php';

$method = isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';
$namespace = isset($_REQUEST['namespace']) ? strtolower($_REQUEST['namespace']) : 'cutting';

switch ($namespace) {
	case 'cutting':
		$calculator = new CostingResource\Cutting\Calculator();
		break;
	case 'spot_welding':
		$calculator = new CostingResource\SpotWelding\Calculator();
		break;
}

$controller = new CalculatorController($calculator);

$method = strtolower($method) . ucfirst($action);

if (is_callable(array($controller, $method))) {

	$result = call_user_func_array(array($controller, $method), array());

	header("HTTP/1.0 200 OK");
    echo json_encode($result);

} else {

	header("HTTP/1.0 400 Bad Request");
    echo json_encode(array());
}
// GET front.php?action=getCalculatorData

// POST front.php?action=validate

// POST front.php?action=calculate