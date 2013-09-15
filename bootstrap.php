<?php 

require __DIR__ . '/src/CostingResource/CalculatorInterface.php';
require __DIR__ . '/src/CostingResource/CsvData.php';

// laser cutting calculator
require __DIR__ . '/src/CostingResource/Cutting/Calculator.php';
require __DIR__ . '/src/CostingResource/Cutting/DataInterface.php';
require __DIR__ . '/src/CostingResource/Cutting/CsvData.php';

// spot welding calculator
require __DIR__ . '/src/CostingResource/SpotWelding/Calculator.php';
require __DIR__ . '/src/CostingResource/SpotWelding/DataInterface.php';
require __DIR__ . '/src/CostingResource/SpotWelding/CsvData.php';

// miscellaneous
require __DIR__ . '/src/CalculatorController.php';
require __DIR__ . '/src/CalculatorView.php';