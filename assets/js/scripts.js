var costingResourceAddErrorMessage,
costingResourceMask,
costingResourceUnmask,
costingResourceDisableTabs,
costingResourceEnableTabs,
costingResourceIsValidPositiveInteger,
costingResourceAddYoutubeVideo,
costingResourceIsValidPositiveFloat,
costingResourceRenderChart,
costingResourceCalculatorData,
costingResourceCallback,
chart,
chartData;

(function ($) {
   costingResourceAddErrorMessage = function ($element, error) {
        $element.parent().find('.error-text').html(error);
    };

    costingResourceMask = function () {
        $("#cm-calculator-div .calculator-tabs").mask("Loading...");
    };

    costingResourceUnmask = function () {
        $("#cm-calculator-div .calculator-tabs").unmask();
    };

    costingResourceDisableTabs = function () {
        $( "#cm-calculator-div" ).tabs( "option", "disabled", [ 1, 2 ] );
        $( "#cm-calculator-div a" )[0].click();
    };

    costingResourceEnableTabs = function () {
        $( "#cm-calculator-div" ).tabs( "option", "disabled", [] );
    };

    costingResourceIsValidPositiveInteger = function (str, acceptZero) {
        acceptZero = acceptZero || false;

        str += '';
        if (str && str.match) {
            if(str.match(/^[0-9]+$/g) !== null) {
                if (!acceptZero && parseInt(str) === 0) return false;
                return true;
            }
        }
        return false;
    };

    costingResourceAddYoutubeVideo = function (id, youtubeId) {
        $('#' + id).empty();

        var $a = $('<a>'),
            $i = $('<i>'),
            $img = $('<img>');

        $a.attr('href', 'http://www.youtube.com/watch?v=' + youtubeId);
        $a.attr('target', '_blank');
        $i.attr('class', 'youtube-icon');
        $a.append($i);
        $img.attr('src', 'http://img.youtube.com/vi/' + youtubeId + '/0.jpg');
        $img.attr('width', 360);
        $img.attr('height', 202);
        $a.append($img);
        $('#' + id).append($a);
    };

    costingResourceIsValidPositiveFloat = function (str, acceptZero) {
        acceptZero = acceptZero || false;

        str += '';
        if (str && str.match) {
            if(str.match(/^[0-9\.]+$/g) !== null) {
                if (str.split('.').length > 2) return false;
                if (!acceptZero && parseFloat(str) === 0) return false;
                return true;
            }
        }
        return false;
    };

    // charting
    costingResourceRenderChart = function (id, data) {
        if (data) { 
            chartData = [
                { cost_type: 'Labour cost' , cost_value: parseFloat(data['labour'])  },
                { cost_type: 'Machine cost', cost_value: parseFloat(data['machine']) },
                { cost_type: 'Overheads'   , cost_value: parseFloat(data['overheads'])    },
                { cost_type: 'Profit'      , cost_value: parseFloat(data['profit'])       }
            ];
            $('#labour-cost-legend').html(parseFloat(data['labour']).toFixed(2));
            $('#machine-cost-legend').html(parseFloat(data['machine']).toFixed(2));
            $('#overheads-legend').html(parseFloat(data['overheads']).toFixed(2));
            $('#profit-legend').html(parseFloat(data['profit']).toFixed(2));
        }

        // pie chart
        chart = new AmCharts.AmPieChart();
        chart.colors = ['#5C94C3', '#CF6460', '#A6C275', '#937AAC'];
        chart.labelsEnabled = true;
        chart.labelText = '[[title]]: [[value]]';
        chart.labelRadius = '15px';
        chart.titleField = "cost_type";
        chart.valueField = "cost_value";
        chart.outlineColor = "#FFFFFF";
        chart.outlineAlpha = 0.8;
        chart.outlineThickness = 2;
        chart.depth3D = 15;
        chart.angle = 30;
        chart.marginBottom = 0;
        chart.marginTop = 0;
        chart.numberFormatter = {
            precision: 2,
            decimalSeparator: '.',
            thousandsSeparator: ','
        };

        chart.dataProvider = chartData;
        chart.write(id);

        $('#cm-calculator-div').off('tabsactivate');
        $('#cm-calculator-div').on('tabsactivate', function (e) {
            // only draw the chart when tab 3 is selected
            chart.write(id);
        });
    };

    costingResourceCallback = function () {
        (function ($) {
    
            // tabs
            $(function() {
                $( "#cm-calculator-div" ).tabs();
                costingResourceDisableTabs();
            });
    
            // load data
            //costingResourceCalculatorData = $.parseJSON('<?php echo json_encode($calculatorData); ?>');
            $('#costing_resource_calculator_namespace').on('change', function (e) {
                var namespace = $(e.target).val();
                $.get(costingResourceFrontControllerUrl + '?namespace=' + namespace).success(function(data) {
                    $('#costing_resource_calculator').get(0).innerHTML = data;
                    
                    if (namespace == 'cutting') costingResourceCuttingCalculatorCallback();
                    if (namespace == 'spot_welding') costingResourceSpotWeldingCalculatorCallback();
                });
            });
            
        } (jQuery));
    };
    
} (jQuery));