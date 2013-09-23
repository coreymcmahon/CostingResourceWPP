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
                'material_id': parseInt($('#material_id').val()),
                'thickness': parseInt($('#thickness').val()),
                'length': parseInt($('#length').val()),
                'holes': parseInt($('#holes').val()),
            };

            if (!costingResourceCuttingCalculatorValidateData(data)) return;

            costingResourceMask();

            $.ajax({
              type: "POST",
              url: "front.php?action=calculate&namespace=cutting",
              data: data,
              success: function (data) { 
                data = $.parseJSON(data); 
                costingResourceCuttingCalculatorPopulateData(data); 
                costingResourceUnmask(); 
                costingResourceEnableTabs(); }
            });
        });
    });

    function costingResourceCuttingCalculatorPopulateData(data) {
        // process
        $('#cutting-speed').val(data['cutting_speed']);
        $('#manipulation-speed').val(data['manipulation_speed']);
        $('#cutting-time').val(data['cutting_time']);
        $('#manipulation-time').val(data['manipulation_time']);
        $('#total-time').val(data['total_time']);
        // machine
        $('#manufacturer').val(data['machine']['manufacturer']);
        $('#machine-size').val(data['machine']['size']);
        $('#cost-per-hour').val(data['machine']['cost_per_hour']);
        // costs
        $('#labour-cost-rate').val(data['costs']['labour_cost_rate']);
        $('#machine-cost-rate').val(data['costs']['machine_cost_rate']);
        $('#cycle-time').val(data['costs']['cycle_time']);
        $('#labour-cost').val(data['costs']['labour_cost']);
        $('#machine-cost').val(data['costs']['machine_cost']);
        $('#overheads').val(data['costs']['overheads']);
        $('#profit').val(data['costs']['profit']);
        $('#price').val(data['costs']['price']);

        costingResourceAddYoutubeVideo('machine-video', data['machine']['youtube']);
        costingResourceRenderChart('chart', data['costs']);
        $('#machine-image').attr('src', '/assets/images/' + data['machine']['image']);
    }

    function costingResourceCuttingCalculatorValidateData(data)
    {
        // @TODO: implement
        return true;
    }
</script>