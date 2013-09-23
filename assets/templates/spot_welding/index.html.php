<div id="cm-calculator-div">
    <ul class='tabs'>
        <li><a href="#tab1" id="tab1-link">Process</a></li>
        <li><a href="#tab2" id="tab2-link">Machine</a></li>
        <li><a href="#tab3" id="tab3-link">Costs</a></li>
    </ul>
    <div id="tab1" class="calculator-tabs">
        <?php include __DIR__ . '/process.html.php'; ?>
    </div>
    <div id="tab2" class="calculator-tabs">
        <?php include __DIR__ . '/machine.html.php'; ?>
    </div>
    <div id="tab3" class="calculator-tabs">
        <?php include __DIR__ . '/costs.html.php'; ?>
    </div>
</div>
<script>
    $(function () {
        $('#calculate-button').on('click', function (e) {
            var data = {
                'is_robotic': parseInt($('#is_robotic').val()),
                'number_of_welds': parseInt($('#number_of_welds').val()),
                'number_of_construction_welds': parseInt($('#number_of_construction_welds').val()),
                'country_id': parseInt($('#country_id').val()),
                'load_quantities': $('#load_weight_1').val() + ',' + $('#load_weight_2').val() + ',' + $('#load_weight_3').val(),
                'unload_quantities': $('#unload_weight_1').val() + ',' + $('#unload_weight_2').val() + ',' + $('#unload_weight_3').val()
            };
            costingResourceSpotWeldingCalculatorCalculate(data);
        });
    });
    function costingResourceSpotWeldingCalculatorCalculate(data) {
        if (!costingResourceSpotWeldingCalculatorValidateData(data)) return;
        costingResourceMask();
        $.ajax({
            type: "POST",
            url: "front.php?action=calculate&namespace=spot_welding",
            data: data,
            success: function (data) { 
                data = $.parseJSON(data); 
                costingResourceSpotWeldingCalculatorPopulateData(data); 
                costingResourceUnmask(); 
                costingResourceEnableTabs(); 
            }
        });
    }
    function costingResourceSpotWeldingCalculatorPopulateData(data) {
        data = data['result'];
        console.log(data);
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
    function costingResourceSpotWeldingCalculatorValidateData(data) {
        // @TODO: implement
        return true;
    }
</script>