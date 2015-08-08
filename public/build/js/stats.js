
$(document).ready(function(){

    // Initializing tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Creating the sales chart
    var salesChartCtx = $('#salesChart').get(0).getContext('2d');
    new Chart(salesChartCtx).Bar(saleData, {
        tooltipTemplate: "<%= value %> sale<%if (value!=1){%>s<%}%>",
        scaleLabel: "<%=value%> sales"
    });

});