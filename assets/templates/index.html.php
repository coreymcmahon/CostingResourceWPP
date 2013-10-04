<div id="costing_resource_calculator">

    <div id="costing_resource_calculator_panel">
    
        <label for="costing_resource_calculator_namespace">Select a Calculator: </label>
        <select name="namespace" id="costing_resource_calculator_namespace" style="width: 200px;">
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