<!doctype html>
<!-- @TODO: remove this -->
<html>
<head>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/assets/css/jquery.loadmask.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="/assets/js/amcharts.js"></script>
    <script src="/assets/js/jquery.loadmask.min.js"></script>
</head>
<body>
<!-- end here -->

<div id="costing_resource_calculator">
	<select name="namespace" id="costing_resource_calculator_namespace">
		
	<?php foreach (CostingResource\Settings::getNamespaces() as $key => $value): ?>
		<option value="<?php echo $key; ?>"<?php if ($namespace === $key): ?> selected="selected"<?php endif; ?>>
			<?php echo $value; ?>
		</option>
	<?php endforeach; ?>

	</select>
	<div id="costing_resource_calculator_panel">
	<?php include __DIR__ . '/' . $namespace . '/index.html.php'; ?>
	</div>
</div>
<script>
    // tabs
    $(function() {
        $( "#cm-cutting-calculator-div" ).tabs();
        costingResourceDisableTabs();
    });

    function costingResourceMask() {
        $("#cm-cutting-calculator-div .calculator-tabs").mask("Loading...");
    }

    function costingResourceUnmask() {
        $("#cm-cutting-calculator-div .calculator-tabs").unmask();
    }

    function costingResourceDisableTabs() {
        $( "#cm-cutting-calculator-div" ).tabs( "option", "disabled", [ 1, 2 ] );
        $( "#cm-cutting-calculator-div a" )[0].click();
    }

    function costingResourceEnableTabs() {
        $( "#cm-cutting-calculator-div" ).tabs( "option", "disabled", [] );
    }

    // load data
	var costingResourceCalculatorData = $.parseJSON('<?php echo json_encode($calculatorData); ?>');
	$('#costing_resource_calculator_namespace').on('change', function (e) {
		var namespace = $(e.target).val();
		$.get('front.php?namespace=' + namespace).success(function(data) {
			$('#costing_resource_calculator').html(data);
		});
	});

    // charting
	function costingResourceRenderChart(id, data) {
        if (data) { 
            chartData = [
                { cost_type: 'Labour cost' , cost_value: parseFloat(data['labour_cost'])  },
                { cost_type: 'Machine cost', cost_value: parseFloat(data['machine_cost']) },
                { cost_type: 'Overheads'   , cost_value: parseFloat(data['overheads'])    },
                { cost_type: 'Profit'      , cost_value: parseFloat(data['profit'])       }
            ];
            $('#labour-cost-legend').html(parseFloat(data['labour_cost']).toFixed(2));
            $('#machine-cost-legend').html(parseFloat(data['machine_cost']).toFixed(2));
            $('#overheads-legend').html(parseFloat(data['overheads']).toFixed(2));
            $('#profit-legend').html(parseFloat(data['profit']).toFixed(2));
        }

        // pie chart
        chart = new AmCharts.AmPieChart();
        chart.colors = ['#5C94C3', '#CF6460', '#A6C275', '#937AAC'];
        chart.labelsEnabled = true;
        chart.labelText = '[[title]]: £[[value]]';
        chart.labelRadius = '15px';
        chart.titleField = "cost_type";
        chart.valueField = "cost_value";
        chart.outlineColor = "#FFFFFF";
        chart.outlineAlpha = 0.8;
        chart.outlineThickness = 2;
        chart.depth3D = 15;
        chart.angle = 30;
        chart.marginBottom = 0;
        chart.marginTop = 0;
        chart.numberFormatter = {
            precision: 2,
            decimalSeparator: '.',
            thousandsSeparator: ','
        };

        chart.dataProvider = chartData;
        chart.write('' + id);
    }
</script>

<!-- @TODO: remove these as they'll appear in the header -->
</body>
</html>