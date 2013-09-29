	<table class="no-top-border">
        <tr class="no-top-border">
            <td class="quarter-width field-label hide-mobile no-top-border">
                <label for="material">Operation Type</label>
            </td>
            <td class="field-value no-top-border">
                <p class="show-mobile mobile-label">Operation Type</p>
                <select name="is_robotic" id="is_robotic">
                	<option value="1">Robotic Welding</option>
                	<option value="0">Manual Welding</option>
                </select>
                <p class="error-text"></p>
            </td>
        </tr>

        <tr>
            <td class="field-label hide-mobile">
                <label for="number_of_welds">Number of Welds</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Number of Welds</p>
                <input autocomplete="off" type="number" id="number_of_welds" name="number_of_welds" class="calculator-field yellow-bg first-inputs" title="Enter number of welds" min="0" />
                <p class="error-text"></p>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="number_of_construction_welds">Number of Construction Welds</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Number of Construction Welds</p>
                <input autocomplete="off" type="number" id="number_of_construction_welds" name="number_of_construction_welds" class="calculator-field yellow-bg first-inputs" title="Enter number of construction welds" min="0" />
                <p class="error-text"></p>
            </td>
        </tr>

        <tr>
            <td class="field-label hide-mobile">
                <strong>Quantity of Parts to Load</strong>
            </td>
            <td class="field-value">&nbsp;</td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="holes">Under 1kg</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Under 1kg</p>
                <input autocomplete="off" type="number" name="load_weight_1" id="load_weight_1" class="calculator-field green-bg first-inputs" title="Enter weight to load under 1 kg" min="0" placeholder="(optional)" />
                <p class="error-text"></p>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="holes">Between 1kg and 8kg</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Between 1kg and 8kg</p>
                <input autocomplete="off" type="number" name="load_weight_2" id="load_weight_2" class="calculator-field green-bg first-inputs" title="Enter weight to load between 1 kg and 8 kg" min="0" placeholder="(optional)" />
                <p class="error-text"></p>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="holes">Between 8kg and 12kg</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Between 8kg and 12kg</p>
                <input autocomplete="off" type="number" name="load_weight_3" id="load_weight_3" class="calculator-field green-bg first-inputs" title="Enter weight to load between 8 kg and 12 kg" min="0" placeholder="(optional)" />
                <p class="error-text"></p>
            </td>
        </tr>

        <tr>
            <td class="field-label hide-mobile">
                <strong>Quantity of Parts to Unload</strong>
            </td>
            <td class="field-value">&nbsp;</td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="holes">Under 1kg</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Under 1kg</p>
                <input autocomplete="off" type="number" name="unload_weight_1" id="unload_weight_1" class="calculator-field green-bg first-inputs" title="Enter weight to unload under 1 kg" min="0" placeholder="(optional)" />
                <p class="error-text"></p>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="holes">Between 1kg and 8kg</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Between 1kg and 8kg</p>
                <input autocomplete="off" type="number" name="unload_weight_2" id="unload_weight_2" class="calculator-field green-bg first-inputs" title="Enter weight to unload between 1 kg and 8 kg" min="0" placeholder="(optional)" />
                <p class="error-text"></p>
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="holes">Between 8kg and 12kg</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Between 8kg and 12kg</p>
                <input autocomplete="off" type="number" name="unload_weight_3" id="unload_weight_3" class="calculator-field green-bg first-inputs" title="Enter weight to unload between 8 kg and 12 kg" min="0" placeholder="(optional)" />
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
                <strong>Outputs</strong>
            </td>
            <td class="field-value no-top-border">&nbsp;</td>
        </tr>

        <tr>
            <td class="field-label hide-mobile">
                <label for="loading_unloading">Loading / Unloading</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Loading / Unloading</p>
                <input autocomplete="off" name="loading_unloading" id="loading_unloading" type="text" readonly="readonly" class="calculator-field" />
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="robot_addr_in_out">Robot address in / out</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Robot address in / out</p>
                <input autocomplete="off" name="robot_addr_in_out" id="robot_addr_in_out" type="text" readonly="readonly" class="calculator-field" />
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="weld_time">Weld time</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Weld time</p>
                <input autocomplete="off" name="weld_time" id="weld_time" type="text" readonly="readonly" class="calculator-field" />
            </td>
        </tr>
        <tr>
            <td class="field-label hide-mobile">
                <label for="controlling_cycle">Controlling cycle</label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Controlling cycle</p>
                <input autocomplete="off" name="controlling_cycle" id="controlling_cycle" type="text" readonly="readonly" class="calculator-field" />
            </td>
        </tr>

        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>


        <tr>
            <td class="field-label hide-mobile">
                <label for="total_time">Total time <small>(secs)</small></label>
            </td>
            <td class="field-value">
                <p class="show-mobile mobile-label">Total time <small>(secs)</small></p>
                <input autocomplete="off" name="total_time" id="total_time" type="text" readonly="readonly" class="calculator-field" />
            </td>
        </tr>


        <tr>
            <td class="hide-mobile"></td>
            <td><button id="calculate-button" class="btn-blue">Calculate cycle time</button></td>
        </tr>
    </table>