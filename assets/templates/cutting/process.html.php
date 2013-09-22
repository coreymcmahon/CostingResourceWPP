	<table class="no-top-border">
        <tr class="no-top-border">
            <td class="quarter-width field-label hide-mobile no-top-border">
                <label for="material">Material</label>
            </td>
            <td class="field-value no-top-border">
                <p class="show-mobile mobile-label">Material</p>
                <select id="material_id" name="material_id" title="Select a material from the dropdown list" class="dark-yellow-bg first-inputs">
                <?php foreach($calculatorData->materials as $material): ?>
                    <option value="<?php echo $material->id; ?>">
                        <?php echo $material->name; ?>
                    </option>
                <?php endforeach; ?>
                </select>
                <p class="error-text"></p>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="thickness">Material thickness <small>(mm)</small></label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Material thickness <small>(mm)</small></p>
                <input autocomplete="off" type="number" id="thickness" name="thickness" class="calculator-field yellow-bg first-inputs" title="Enter thickness of material to be cut" min="0" />
                <input type="hidden" id="max-thicknesses" name="max-thicknesses" value="">
                <p class="maximum-thickness-text"></p>
                <p class="error-text"></p>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="length">Total length to cut <small>(mm)</small></label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Total length to cut <small>(mm)</small></p>
                <input autocomplete="off" type="number" name="length" id="length" class="calculator-field yellow-bg first-inputs" title="Enter thickness of material to be cut" min="0" />
                <p class="error-text"></p>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="holes">No of holes / apetures</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">No of holes / apetures</p>
                <input autocomplete="off" type="number" name="holes" id="holes" class="calculator-field yellow-bg first-inputs" title="Enter total length of cut" min="0" />
                <p class="error-text"></p>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="cutting-speed-optional">Cutting Speed <small>(mm / min)</small></label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Cutting Speed <small>(mm / min)</small></p>
                <input autocomplete="off" type="number" id="cutting-speed-optional" name="cutting-speed-optional" class="calculator-field green-bg first-inputs" placeholder="(optional)" min="0" />
                <p class="error-text"></p>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="manipulation-speed-optional">Manipulation Speed <small>(mm / min)</small></label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Manipulation Speed <small>(mm / min)</small></p>
                <input autocomplete="off" type="number" id="manipulation-speed-optional" name="manipulation-speed-optional" class="calculator-field green-bg first-inputs" placeholder="(optional)" min="0" />
                <p class="error-text"></p>
            </td>
        </tr>
        <tr>
            <td class="hide-mobile"></td>
            <td><button id="clear-button" class="btn-red">Clear all data</button></td>
        </tr>
        <tr class="no-borders">
            <td colspan="2" class="no-borders"><hr></td>
        </tr>
        <tr class="no-top-border">
            <td class="field-label hide-mobile no-top-border">
                <label for="cutting-speed">Cutting Speed <small>(mm / min)</small></label>
            </td>
            <td class="field-value no-top-border">
                <p class="show-mobile mobile-label">Cutting Speed <small>(mm / min)</small></p>
                <input autocomplete="off" type="text" name="cutting-speed" id="cutting-speed" readonly="readonly" class="calculator-field" />
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="manipulation-speed">Manipulation Speed <small>(mm / min)</small></label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Manipulation Speed <small>(mm / min)</small></p>
                <input autocomplete="off" type="text" name="manipulation-speed" id="manipulation-speed" readonly="readonly" class="calculator-field" />
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="cutting-time">Cutting Time <small>(min)</small></label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Cutting Time <small>(min)</small></p>
                <input autocomplete="off" type="text" name="cutting-time" id="cutting-time" readonly="readonly" class="calculator-field" />
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="manipulation-time">Manipulation Time <small>(min)</small></label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Manipulation Time <small>(min)</small></p>
                <input autocomplete="off" type="text" name="manipulation-time" id="manipulation-time" readonly="readonly" class="calculator-field" />
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="total-time">Total Time <small>(min)</small></label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Total Time <small>(min)</small></p>
                <input autocomplete="off" type="text" name="total-time" id="total-time" readonly="readonly" class="calculator-field light-blue" />
            </td>
        </tr>
        <tr>
            <td class="hide-mobile"></td>
            <td><button id="calculate-button" class="btn-blue">Calculate cycle time</button></td>
        </tr>
    </table>