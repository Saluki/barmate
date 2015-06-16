
$(document).ready(function(){

    console.log('Stat component ready');

    var salesChartCtx = $('#salesChart').get(0).getContext('2d');
    var salesChart = new Chart(salesChartCtx).Bar(saleData, {
        tooltipTemplate: "<%= value %> sale<%if (value!=1){%>s<%}%>",
        scaleLabel: "<%=value%> sales"
    });

});