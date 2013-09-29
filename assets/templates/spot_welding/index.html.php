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
(function ($) {
    $(function () {
        $('#calculate-button').on('click', costingResourceSpotWeldingCalculatorCalculate);
        $('#country_id').on('change', costingResourceSpotWeldingCalculatorCalculate);

        $('#clear-button').on('click', function () {
            $('#tab1-link').click();
            costingResourceDisableTabs();
            $('input.calculator-field').val('');
        });
    });
} (jQuery));
</script>