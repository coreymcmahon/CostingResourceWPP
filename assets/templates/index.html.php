<div id="costing_resource_calculator">

    <div id="costing_resource_calculator_panel">
    
        <label for="costing_resource_calculator_namespace">Select a Calculator: </label>
        <select name="namespace" id="costing_resource_calculator_namespace">
            <?php foreach (CostingResource\Settings::getNamespaces() as $key => $value): ?>
                <option value="<?php echo $key; ?>"<?php if ($namespace === $key): ?> selected="selected"<?php endif; ?>>
                <?php echo $value; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div>&nbsp;</div>

        <?php include __DIR__ . '/' . $namespace . '/index.html.php'; ?>
    </div>

</div>
<script>
    var chart, chartData, costingResourceCalculatorData;

    (function ($) {
    
            // tabs
            $(function() {
                $( "#cm-calculator-div" ).tabs();
                costingResourceDisableTabs();
            });
    
            // load data
            costingResourceCalculatorData = $.parseJSON('<?php echo json_encode($calculatorData); ?>');
            $('#costing_resource_calculator_namespace').on('change', function (e) {
                var namespace = $(e.target).val();
                $.get(costingResourceFrontControllerUrl + '?namespace=' + namespace).success(function(data) {
                    $('#costing_resource_calculator').html(data);
                });
            });
            
        } (jQuery));
</script>