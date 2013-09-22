<div id="cm-cutting-calculator-div">
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

            $.ajax({
              type: "POST",
              url: "front.php?action=calculate&namespace=cutting",
              data: data,
              success: function (data) { console.log(data); }
            });
        });
    });
</script>