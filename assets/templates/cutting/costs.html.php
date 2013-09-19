	<div style="width: 300px;">
        <table class="no-top-border">
            <tr class="no-top-border">
                <td class="field-label hide-mobile no-top-border">
                    <label for="country-id">Select Country</label>
                </td>
                <td class="field-value no-top-border">
                    <p class="show-mobile mobile-label">Select Country</p>
                    <select id="country-id" name="country-id" title="Select a country from the dropdown list" class="dark-yellow-bg">
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
                    <label for="labour-cost-rate">Labour cost rate <small>(&pound; per hour)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Labour cost rate <small>(&pound; per hour)</small></p>
                    <input autocomplete="off" type="text" id="labour-cost-rate" name="labour-cost-rate" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="machine-cost-rate">Machine cost rate <small>(&pound; per hour)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Machine cost rate <small>(&pound; per hour)</small></p>
                    <input autocomplete="off" type="text" id="machine-cost-rate" name="machine-cost-rate" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="cycle-time">Cycle time <small>(mins)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Cycle time <small>(mins)</small></p>
                    <input autocomplete="off" type="text" id="cycle-time" name="cycle-time" readonly="readonly" class="calculator-field light-blue" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="labour-cost">Labour cost <small>(&pound;)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Labour cost <small>(&pound;)</small></p>
                    <input autocomplete="off" type="text" id="labour-cost" name="labour-cost" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="machine-cost">Machine cost <small>(&pound;)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Machine cost <small>(&pound;)</small></p>
                    <input autocomplete="off" type="text" id="machine-cost" name="machine-cost" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="overheads">Overheads <small>(&pound;)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Overheads <small>(&pound;)</small></p>
                    <input autocomplete="off" type="text" id="overheads" name="overheads" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="profit">Profit <small>(&pound;)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Profit <small>(&pound;)</small></p>
                    <input autocomplete="off" type="text" id="profit" name="profit" readonly="readonly" class="calculator-field" />
                </td>
            </tr>
            <tr>
                <td class="field-label hide-mobile">
                    <label for="price">Price <small>(&pound;)</small></label>
                </td>
                <td class="field-value">
                    <p class="show-mobile mobile-label">Price <small>(&pound;)</small></p>
                    <input autocomplete="off" type="text" id="price" name="price" readonly="readonly" class="calculator-field light-blue" />
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