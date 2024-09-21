var gastosXmes = [];

function renderChart(data) {
    Highcharts.chart('contenedorgrafico', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Gastos por Mes',
            align: 'left'
        },
        xAxis: {
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ],
            crosshair: true,
            accessibility: {
                description: 'Meses'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Cantidad (S/.)'
            }
        },
        tooltip: {
            valueSuffix: ' soles'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Gastos',
            data: data
        }]
    });
}

document.addEventListener('DOMContentLoaded', function() {
    renderChart(gastosXmes); // Renderiza el gráfico inicialmente
    document.getElementById('yearSelector').addEventListener('change', function() {
        var selectedYear = this.value;
        fetch(`/get-gastos?year=${selectedYear}`)
            .then(response => response.json())
            .then(data => {
                renderChart(data); // Renderiza el gráfico con los nuevos datos
            })
            .catch(error => console.error('Error fetching data:', error));
    });
});