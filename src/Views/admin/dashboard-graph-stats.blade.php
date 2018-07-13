<!-- resources/views/vendor/burnermap/admin/dashboard-graph-stats.blade.php -->
<link rel="stylesheet" type="text/css" href="/js/flot-master/simpleStyle.css">
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="/js/flot-master/excanvas.min.js"
    ></script><![endif]-->
<script language="javascript" type="text/javascript" src="/js/flot-master/jquery.js"></script>
<script language="javascript" type="text/javascript" src="/js/flot-master/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="/js/flot-master/jquery.flot.time.js"></script>
<script language="javascript" type="text/javascript" src="/js/flot-master/jquery.flot.axislabels.js"></script>
<script type="text/javascript"> 
$(document).ready(function () {
    function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
    }
    var data0 = [
    {!! substr($dataLineTxt[0], 2) !!}
    ];
    var data1 = [
    {!! substr($dataLineTxt[1], 2) !!}
    ];
    var data2 = [
    {!! substr($dataLineTxt[2], 2) !!}
    ];
    var data3 = [
    {!! substr($dataLineTxt[3], 2) !!}
    ];
    var data4 = [
    {!! substr($dataLineTxt[4], 2) !!}
    ];
    var dataset = [
        {
            label: "Page Loads/10",
            data: data0,
            color: "#EFAAAA",
            points: { fillColor: "#EFAAAA", show: true },
            lines: { show: true }
        },
        {
            label: "Loads Unique",
            data: data1,
            xaxis:2,
            color: "#EF554B",
            points: { fillColor: "#EF554B", show: true },
            lines: { show: true }
        },
        {
            label: "Status Edits",
            data: data2,
            xaxis:2,
            color: "#BBFFBB",
            points: { fillColor: "#BBFFBB", show: true },
            lines: { show: true }
        },
        {
            label: "Edits Unique",
            data: data3,
            xaxis:2,
            color: "#00FF00",
            points: { fillColor: "#00FF00", show: true },
            lines: { show: true }
        },
        {
            label: "New Users",
            data: data4,
            xaxis:2,
            color: "#0000FF",
            points: { fillColor: "#0000FF", show: true },
            lines: { show: true }
        }
    ];
    var dayOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thr", "Fri", "Sat"];
    var options = {
        series: {
            shadowSize: 5
        },
        xaxes: [{
            mode: "time",                
            tickFormatter: function (val, axis) {
                return dayOfWeek[new Date(val).getDay()];
            },
            color: "black",
            position: "top",
            axisLabel: "Day of week",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 5
        },
        {
            mode: "time",
            timeformat: "%m/%d",
            tickSize: [3, "day"],
            color: "black",        
            axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10
        }],
        yaxis: {        
            color: "black",
            tickDecimals: 0,
            axisLabel: "Daily Totals",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 5
        },
        legend: {
            noColumns: 0,
            labelFormatter: function (label, series) {
                return "<font color=\"white\">" + label + "</font>";
            },
            backgroundColor: "#000",
            backgroundOpacity: 0.8,
            labelBoxBorderColor: "#000000",
            position: "nw"
        },
        grid: {
            hoverable: true,
            borderWidth: 3,
            mouseActiveRadius: 50,
            backgroundColor: { colors: ["#ffffff", "#EDF5FF"] },
            axisMargin: 20
        }
    };

    $.plot($("#placeholder"), dataset, options);
    /* $("#placeholder").UseTooltip(); */
});
</script>

<div id="content"><div class="demo-container">
    <div id="placeholder" class="demo-placeholder" style="width: 699px; height: 365px;"></div>
</div></div>