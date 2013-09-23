	<div style="width: 300px;">
        <table class="no-top-border">
            <tr class="no-top-border">
                <td class="field-label hide-mobile no-top-border">
                    <label for="country_id">Select Country</label>
                </td>
                <td class="field-value no-top-border">
                    <p class="show-mobile mobile-label">Select Country</p>
                    <select id="country_id" name="country_id" title="Select a country from the dropdown list" class="dark-yellow-bg">
                    <?php foreach($calculatorData->countries as $country): ?>
                        <option value="<?php echo $country->id; ?>">
                            <?php echo $country->name; ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="labour_cost_rate">Labour cost rate <small>(&pound; per hour)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Labour cost rate <small>(&pound; per hour)</small></p>
                    <input autocomplete="off" type="text" id="labour_cost_rate" name="labour_cost_rate" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="machine_cost_rate">Machine cost rate <small>(&pound; per hour)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Machine cost rate <small>(&pound; per hour)</small></p>
                    <input autocomplete="off" type="text" id="machine_cost_rate" name="machine_cost_rate" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="cycle_time">Cycle time <small>(mins)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Cycle time <small>(mins)</small></p>
                    <input autocomplete="off" type="text" id="cycle_time" name="cycle_time" readonly="readonly" class="calculator-field light-blue" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="cost_labour">Labour cost <small>(&pound;)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Labour cost <small>(&pound;)</small></p>
                    <input autocomplete="off" type="text" id="cost_labour" name="cost_labour" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="cost_machine">Machine cost <small>(&pound;)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Machine cost <small>(&pound;)</small></p>
                    <input autocomplete="off" type="text" id="cost_machine" name="cost_machine" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="cost_overheads">Overheads <small>(&pound;)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Overheads <small>(&pound;)</small></p>
                    <input autocomplete="off" type="text" id="cost_overheads" name="cost_overheads" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="cost_profit">Profit <small>(&pound;)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Profit <small>(&pound;)</small></p>
                    <input autocomplete="off" type="text" id="cost_profit" name="cost_profit" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="cost_price">Price <small>(&pound;)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Price <small>(&pound;)</small></p>
                    <input autocomplete="off" type="text" id="cost_price" name="cost_price" readonly="readonly" class="calculator-field light-blue" />
                </td>
            </tr>
        </table>
    </div>
    
    <div id="chart-div" class="hide-mobile">
        <div id="chart" class="calculator-field"></div>
        <div id="chart-legend">
            <table>
                <tr>
                    <td><i class="blue">&nbsp;</i><span class="legend-label">Labour cost</span></td>
                    <td class="legend-value">&pound;<span id="labour-cost-legend"></span></td>
                    <td><i class="red">&nbsp;</i><span class="legend-label">Machine cost</span></td>
                    <td class="legend-value">&pound;<span id="machine-cost-legend"></span></td>
                </tr>
                <tr>
                    <td><i class="green">&nbsp;</i><span class="legend-label">Overheads</span></td>
                    <td class="legend-value">&pound;<span id="overheads-legend"></span></td>
                    <td><i class="purple">&nbsp;</i><span class="legend-label">Profit</span></td>
                    <td class="legend-value">&pound;<span id="profit-legend"></span></td>
                </tr>
            </table>
        </div>
    </div>
    
  </div>