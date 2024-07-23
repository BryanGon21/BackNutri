<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <div class"flex-center position-ref full-height">
    <div class="content">
        <div align="center">
            <div id="draw-charts"></div>
        </div>
        <form action="/print_chart" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="chartData" id="chartInputData">
            <input type="submit" value="Print Chart">

        </form>

        <script 

        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous">
        ></script>


        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
    (function(){
        let altura = @json($altura);
        let peso = @json($peso);

        let grafico = [altura, peso];
        for (let r=0; r<grafico.length; r++){
            $("#draw-charts").append("<div id='draw-charts"+r+"'></div>");
            google.charts.load('current', {
                callback: function(){
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Mes');
                    data.addColumn('number', 'valor');
                    data.addRows(grafico[r]);
                    var options = {
                        title: 'Datos estadisticos',
                        width: 800,
                        height: 300,
                        // Opciones específicas para LineChart
                        legend: { position: 'top' },
                        curveType: 'function',
                        pointSize: 5,
                        // Configuración del eje horizontal
                        hAxis: {
                            title: 'Mes',
                            format: 'MMMM', // Formato de los meses
                            gridlines: {
                                count: -1, // Muestra todas las líneas de cuadrícula
                                units: {
                                    months: {format: ['MMMM']}
                                }
                            }
                        }
                    };
                    let chart_div = document.getElementById("draw-charts"+r);
                    let chart = new google.visualization.LineChart(chart_div);

                    google.visualization.events.addListener(chart, 'ready', function(){
                        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
                    });

                    chart.draw(data, options);
                },
                packages: ['corechart']
            });
        }
        setTimeout(function() {
            let chartsData = $("#draw-charts").html();  
            $("#chartInputData").val(chartsData);   
        }, 1000);
        
    })();
</script>
        </div>
        </div>
</body>
</html>

