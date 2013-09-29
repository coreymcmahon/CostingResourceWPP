var costingResourceSpotWeldingCalculatorError,
costingResourceSpotWeldingCalculatorCalculate,
costingResourceSpotWeldingCalculatorPopulateData,
costingResourceSpotWeldingCalculatorValidateData;

(function ($) {
	costingResourceSpotWeldingCalculatorError = function () {
		alert('An error occurred while trying to perform the calculation.');
		costingResourceDisableTabs(); 
		costingResourceUnmask();
	}

	costingResourceSpotWeldingCalculatorCalculate = function () {
		var data = {
			'is_robotic': parseInt($('#is_robotic').val()),
			'number_of_welds': parseInt($('#number_of_welds').val()),
			'number_of_construction_welds': parseInt($('#number_of_construction_welds').val()),
			'country_id': parseInt($('#country_id').val()),
			'load_quantities': $('#load_weight_1').val() + ',' + $('#load_weight_2').val() + ',' + $('#load_weight_3').val(),
			'unload_quantities': $('#unload_weight_1').val() + ',' + $('#unload_weight_2').val() + ',' + $('#unload_weight_3').val()
		};

		if (!costingResourceSpotWeldingCalculatorValidateData(data)) return;
		costingResourceMask();
		$.ajax({
			type: "POST",
			url: costingResourceFrontControllerUrl + "?action=calculate&namespace=spot_welding",
			data: data
		}).success(function (data) { 
			data = $.parseJSON(data); 
			if (data == null) return costingResourceSpotWeldingCalculatorError();
			
			costingResourceSpotWeldingCalculatorPopulateData(data); 
			costingResourceUnmask(); 
			costingResourceEnableTabs(); 
		}).error(costingResourceSpotWeldingCalculatorError);
	}

	costingResourceSpotWeldingCalculatorPopulateData = function (data) {
	data = data['result'];
		// process
		$('#loading_unloading').val(data['loading_unloading']);
		$('#robot_addr_in_out').val(data['robot_addr_in_out']);
		$('#weld_time').val(data['weld_time']);
		$('#controlling_cycle').val(data['controlling_cycle']);
		$('#total_time').val(data['total_time']);
		// machine
		$('#machine_name').val(data['machine']['name']);
		$('#machine_manufacturer').val(data['machine']['manufacturer']);
		$('#machine_size').val(data['machine']['size']);
		$('#machine_rate').val(data['machine']['rate']);
		// costs
		$('#labour_cost_rate').val(data['country']['labour_rate']);
		$('#machine_cost_rate').val(data['machine']['rate']);
		$('#cycle_time').val(data['cycle_time']);
		$('#cost_labour').val(data['costs']['labour']);
		$('#cost_machine').val(data['costs']['machine']);
		$('#cost_overheads').val(data['costs']['overheads']);
		$('#cost_profit').val(data['costs']['profit']);
		$('#cost_price').val(data['costs']['price']);

		costingResourceAddYoutubeVideo('machine_video', data['machine']['video']);
		costingResourceRenderChart('chart', data['costs']);
		$('#machine_image').attr('src', '/assets/images/' + data['machine']['image']);
	}

	costingResourceSpotWeldingCalculatorValidateData = function (data) {
		$('#cm-calculator-div .error-text').html('');

		var $isRobotic = $('#is_robotic'),
		$numberOfWelds = $('#number_of_welds'),
		$numberOfConstructionWelds = $('#number_of_construction_welds'),
		$loadWeight1 = $('#load_weight_1'),
		$loadWeight2 = $('#load_weight_2'),
		$loadWeight3 = $('#load_weight_3'),
		$unloadWeight1 = $('#unload_weight_1'),
		$unloadWeight2 = $('#unload_weight_2'),
		$unloadWeight3 = $('#unload_weight_3'),
		validates = true;

		if (!costingResourceIsValidPositiveInteger($numberOfWelds.val())) {
			validates = false;
			costingResourceAddErrorMessage($numberOfWelds, 'Number of welds must be a valid positive number');
			$numberOfWelds.focus();
		}
		if (!costingResourceIsValidPositiveInteger($numberOfConstructionWelds.val())) {
			validates = false;
			costingResourceAddErrorMessage($numberOfConstructionWelds, 'Number of construction welds must be a valid positive number');
			$numberOfConstructionWelds.focus();
		} else if (parseInt($numberOfConstructionWelds.val()) > parseInt($numberOfWelds.val())) {
			validates = false;
			costingResourceAddErrorMessage($numberOfConstructionWelds, 'Number of construction welds must be less than total number of welds');
			$numberOfConstructionWelds.focus();
		}
		// ....
		if (($loadWeight1.val() !== '') && !costingResourceIsValidPositiveInteger($loadWeight1.val(), true)) {
			validates = false;
			costingResourceAddErrorMessage($loadWeight1, 'If provided, load weight must be a valid positive number');
			$loadWeight1.focus();
		}
		if (($loadWeight2.val() !== '') && !costingResourceIsValidPositiveInteger($loadWeight2.val(), true)) {
			validates = false;
			costingResourceAddErrorMessage($loadWeight2, 'If provided, load weight must be a valid positive number');
			$loadWeight2.focus();
		}
		if (($loadWeight3.val() !== '') && !costingResourceIsValidPositiveInteger($loadWeight3.val(), true)) {
			validates = false;
			costingResourceAddErrorMessage($loadWeight3, 'If provided, load weight must be a valid positive number');
			$loadWeight3.focus();
		}
		// ...
		if (($unloadWeight1.val() !== '') && !costingResourceIsValidPositiveInteger($unloadWeight1.val(), true)) {
			validates = false;
			costingResourceAddErrorMessage($unloadWeight1, 'If provided, unload weight must be a valid positive number');
			$unloadWeight1.focus();
		}
		if (($unloadWeight2.val() !== '') && !costingResourceIsValidPositiveInteger($unloadWeight2.val(), true)) {
			validates = false;
			costingResourceAddErrorMessage($unloadWeight2, 'If provided, unload weight must be a valid positive number');
			$unloadWeight2.focus();
		}
		if (($unloadWeight3.val() !== '') && !costingResourceIsValidPositiveInteger($unloadWeight3.val(), true)) {
			validates = false;
			costingResourceAddErrorMessage($unloadWeight3, 'If provided, unload weight must be a valid positive number');
			$unloadWeight3.focus();
		}

		return validates;
	}
} (jQuery));