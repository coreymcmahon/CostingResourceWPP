	<table class="no-top-border">
        <tr class="no-top-border">
            <td class="quarter-width field-label hide-mobile no-top-border">
                <label for="machine-id" title="Select a machine from the dropdown list">Select Machine</label>
            </td>
            <td class="field-value no-top-border">
                <p class="show-mobile mobile-label">Select Machine</p>
                <select id="machine-id" name="machine-id" class="dark-yellow-bg">
                <?php foreach($calculatorData->machines as $machine): ?>
                <option value="<?php echo $machine->id; ?>">
                    <?php echo $machine->name; ?>
                </option>
                <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="manufacturer">Manufacturer</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Manufacturer</p>
                <input autocomplete="off" type="text" name="manufacturer" id="manufacturer" readonly="readonly" class="calculator-field" />
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="machine-size">Machine size</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Machine size</p>
                <input autocomplete="off" type="text" name="machine-size" id="machine-size" readonly="readonly" class="calculator-field" />
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label>Machine image</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Machine image</p>
                <img src="" width="360" height="240" alt="Machine image" id="machine-image" class="calculator-field">
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label>Process video</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Process video</p>
                <div class="calculator-field" id="machine_video"></div>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="cost-per-hour">Cost per hour <small>(&pound;)</small></label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Cost per hour <small>(&pound;)</small></p>
                <input autocomplete="off" type="text" name="cost-per-hour" id="cost-per-hour" readonly="readonly" class="calculator-field light-blue" />
            </td>
        </tr>
    </table>
