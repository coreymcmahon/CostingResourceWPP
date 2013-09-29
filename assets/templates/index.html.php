<div id="costing_resource_calculator">

    <div id="costing_resource_calculator_panel">
        
    <select name="namespace" id="costing_resource_calculator_namespace">
        <?php foreach (CostingResource\Settings::getNamespaces() as $key => $value): ?>
            <option value="<?php echo $key; ?>"<?php if ($namespace === $key): ?> selected="selected"<?php endif; ?>>
            <?php echo $value; ?>
            </option>
        <?php endforeach; ?>
    </select>

        <?php include __DIR__ . '/' . $namespace . '/index.html.php'; ?>
    </div>

</div>
<script>
    var chart, chartData;

    function ($) {

        // tabs
        $(function() {
            $( "#cm-calculator-div" ).tabs();
            costingResourceDisableTabs();
        });

        // load data
        var costingResourceCalculatorData = $.parseJSON('<?php echo json_encode($calculatorData); ?>');
        $('#costing_resource_calculator_namespace').on('change', function (e) {
            var namespace = $(e.target).val();
            $.get('front.php?namespace=' + namespace).success(function(data) {
                $('#costing_resource_calculator').html(data);
            });
        });
        
    } (jQuery);
</script>