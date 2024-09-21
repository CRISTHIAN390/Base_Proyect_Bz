var gastosXmes = [];
var ingresosXmes = [];

function renderGastosChart(data) {
    Highcharts.chart('contenedorgrafico', {
        chart: { type: 'column' },
        title: { text: 'Gastos por Mes', align: 'left' },
        xAxis: {
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                         'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            crosshair: true,
            accessibility: { description: 'Meses' }
        },
        yAxis: {
            min: 0,
            title: { text: 'Cantidad (S/.)' }
        },
        tooltip: { valueSuffix: ' soles' },
        plotOptions: {
            column: { pointPadding: 0.2, borderWidth: 0 }
        },
        series: [{ name: 'Gastos', data: data }]
    });
}

function renderIngresosChart(data) {
    Highcharts.chart('contenedorgrafico2', {
        chart: { type: 'column' },
        title: { text: 'Ingresos por Mes', align: 'left' },
        xAxis: {
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                         'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            crosshair: true,
            accessibility: { description: 'Meses' }
        },
        yAxis: {
            min: 0,
            title: { text: 'Cantidad (S/.)' }
        },
        tooltip: { valueSuffix: ' soles' },
        plotOptions: {
            column: { pointPadding: 0.2, borderWidth: 0 }
        },
        series: [{ name: 'Ingresos', data: data }]
    });
}


function renderIGChart(dataG,dataI) {
        Highcharts.chart('container', {
            chart: {
                type: 'line'
            },
            title: {
                text: ' '
            },
            xAxis: {
                categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
            },
            yAxis: {
                title: {
                    text: 'Montos S/.'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [
                { name: 'Ingresos', data: dataI },
                 { name: 'Gastos', data: dataG }
                ]
        });
}

document.addEventListener('DOMContentLoaded', function() {
    renderGastosChart(gastosXmes); // Renderiza el gráfico de gastos inicialmente
    renderIngresosChart(ingresosXmes); // Renderiza el gráfico de ingresos inicialm
    renderIGChart(gastosXmes, ingresosXmes); // Renderiza el gráfico vacío inicialmente
    
     ente
    renderIGChart(gastosXmes,ingresosXmes)
    document.getElementById('yearSelector').addEventListener('change', function() {
        var selectedYear = this.value;
        fetch(`/get-gastos?year=${selectedYear}`)
            .then(response => response.json())
            .then(data => {
                renderGastosChart(data); // Renderiza el gráfico de gastos con los nuevos datos
            })
            .catch(error => console.error('Error fetching data:', error));
    });

    document.getElementById('yearSelector2').addEventListener('change', function() {
        var selectedYear = this.value;
        fetch(`/get-ingresos?year=${selectedYear}`)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Verifica la respuesta aquí
                if (data && data.length) {
                    renderIngresosChart(data); // Solo renderiza si hay datos
                } else {
                    console.warn('No hay datos para renderizar el gráfico de ingresos');
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    });

    // Selector para actualizar tanto los gastos como los ingresos
    document.getElementById('yearSelector3').addEventListener('change', function() {
        var selectedYear = this.value;
        fetch(`/get-gasingre?year=${selectedYear}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.gastos && data.ingresos) {
                    gastosXmes = data.gastos;
                    ingresosXmes = data.ingresos;
                    renderIGChart(gastosXmes, ingresosXmes); // Actualiza el gráfico combinado
                } else {
                    console.warn('No hay datos para renderizar el gráfico');
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    });
});