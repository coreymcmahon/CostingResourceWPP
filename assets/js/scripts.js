function ($) {
   function costingResourceAddErrorMessage($element, error) {
        $element.parent().find('.error-text').html(error);
    }

    function costingResourceMask() {
        $("#cm-calculator-div .calculator-tabs").mask("Loading...");
    }

    function costingResourceUnmask() {
        $("#cm-calculator-div .calculator-tabs").unmask();
    }

    function costingResourceDisableTabs() {
        $( "#cm-calculator-div" ).tabs( "option", "disabled", [ 1, 2 ] );
        $( "#cm-calculator-div a" )[0].click();
    }

    function costingResourceEnableTabs() {
        $( "#cm-calculator-div" ).tabs( "option", "disabled", [] );
    }

    function costingResourceIsValidPositiveInteger(str, acceptZero) {
        acceptZero = acceptZero || false;

        str += '';
        if (str && str.match) {
            if(str.match(/^[0-9]+$/g) !== null) {
                if (!acceptZero && parseInt(str) === 0) return false;
                return true;
            }
        }
        return false;
    }

    function costingResourceAddYoutubeVideo(id, youtubeId) {
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
    }

    function costingResourceIsValidPositiveFloat(str, acceptZero) {
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
    }

    // charting
    function costingResourceRenderChart(id, data) {
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
        $('#cm-calculator-div').on('tabsactivate', function (e) { chart.write(id); });
    }
} (jQuery);