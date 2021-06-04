@extends('layouts.application')

@section('content')

<html>

<head>
  <title>Controle Veiculos</title>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

  <style type="text/css">
    .box {
      width: 300px;
      margin: 0 auto;
    }
  </style>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body>

  <h1 class="ls-title-intro ls-ico-chart-bar-up">Custos por veículos</h1>
  <div class="ls-box">
    <div id="section-table">
      <div class="ls-box">
        <div class="box-header">
          <form method="post" action="{{ route('vehicle-cost') }}" class="form form-inline">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <fieldset class="col-md-12">
              <div class="col-md-4"></div>
              <label class="ls-label col-md-8" style="margin-bottom: 20px;">
                <div class="col-md-4">
                  <input type="date" name="datainicio" required>
                </div>
                <div class="col-md-4">
                  <input type="date" name="datafim" required>
                </div>
                <div class="col-col-md-2">
                  <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
                <div class="col-col-md-2" style="margin-left: 5px;">
                  <a class="ls-btn-primary-danger" href="/vehicle-cost">Limpar</a>
                </div>
              </label>
            </fieldset>
          </form>
        </div>

        <div class="col-md-12">
          <div id="table">
            <table id="tab1" class="display">
              <thead>
                <th>&nbsp;</th>
                <th>Veículo</th>
                <th>Km's rodados</th>
                <th>Combustível(L)</th>
                <th>Km/L</th>
                <th>Total combustível(R$)</th>
                <th>Manutenção(R$)</th>
                <th>Manutenção/Km's rodados</th>
                <th>TOTAL</th>
                <th>Custo por Km Rodado</th>
              </thead>
              <tbody id="tbody">
                <tr>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="ls-box">
      <div class="col-md-12" style="height: 450px;">
        <h6>Os graficos são dinamicos a partir de filtro</h6>
        <div class="col-md-6">
          <div id="kmscharts" style="width: 700px; height: 350px;"></div>
        </div>
        <div class="col-md-6">
          <div id="costbykmcharts" style="width: 700px; height: 350px;"></div>
        </div>
      </div>
    </div>

  </div>

  <script type="text/javascript">
    var default_list = <?php echo $default_list; ?>;
    var expenses = <?php echo $expenses; ?>;
    var count = Object.keys(expenses).length;
    var table = document.getElementById("tab1")[0]; // sugestão, coloque um id na tabela para usar getElementById.
    var maintenance_km = 0;
    var expense = 0
    var total = 0;
    // var arrayTotalCost = [];

    // limpar tbody

    tbody.innerHTML = "";

    function valueOrNull(value) {

      var newValue = 0.00;

      if (value === null || isNaN(value)) {
        return newValue;
      } else {
        return newValue = value;
      }

    }

    //adicionar as linha na tabela
    for (var i = 1; i < count + 1; i++) {
      var kilometers_wheels = 0;
      var spent_fuel = 0;
      var maintenance_expense = 0;
      var fuel_consumed = 0;

      if (default_list == 0) {
        kilometers_wheels = expenses[i][4][0];
        spent_fuel = expenses[i][5][0];
        maintenance_expense = expenses[i][6][0];
        fuel_consumed = expenses[i][7][0]
      } else {
        kilometers_wheels = expenses[i][4][0].km;
        spent_fuel = expenses[i][5][0].fuel_consumed;
        maintenance_expense = expenses[i][6][0].maintenance;
        fuel_consumed = expenses[i][7][0].fuel_consumed;
      }

      total = (parseFloat(fuel_consumed) + parseFloat(maintenance_expense))

      // arrayTotalCost.push(parseFloat(valueOrNull(total / kilometers_wheels)));
      tbody.innerHTML += "<tr><td>" + i +
        "</td><td>" //indice
        +
        expenses[i][1] + ' ' + expenses[i][2] + " - " + expenses[i][3] + "</td><td>" //Veículo
        +
        valueOrNull(parseFloat(kilometers_wheels)).toFixed(2) + "</td><td>" //Kms rodados
        +
        valueOrNull(parseFloat(spent_fuel)).toFixed(2) + "</td><td>" //Combustível
        +
        valueOrNull(parseFloat(kilometers_wheels / spent_fuel)).toFixed(2) + "</td><td>" // Combustivel(/)km
        +
        valueOrNull(parseFloat(fuel_consumed)).toFixed(2) + "</td><td>" //Total Pago
        +
        valueOrNull(parseFloat(maintenance_expense)).toFixed(2) + "</td><td>" //Manutenção
        +
        valueOrNull(parseFloat(maintenance_expense / kilometers_wheels)).toFixed(2) + "</td><td>" // Manutenção(/)km
        +
        valueOrNull(parseFloat(total)).toFixed(2) + "</td><td>" // TOTAL (Combustivel + Manutenção)
        +
        valueOrNull(parseFloat(total / kilometers_wheels)).toFixed(2) + "</td></tr>" // Custo por Km Rodado
        +
        "</tr>"
    }
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#tab1').DataTable({
        dom: 'Bfrtip',
        buttons: [
          'copyHtml5',
          'excelHtml5',
          'csvHtml5',
          {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL'
          }
        ]
      });
    });
  </script>

  <!-- Gráficos Pizza -->
  <script type="text/javascript">
    var graph_expenses = <?php echo $expenses; ?>;
    var default_list = <?php echo $default_list; ?>;
    var iterator = Object.keys(graph_expenses).length;
    var arraykeys = [];
    var arrayValues = [];

    // Iniciando array com titulo do gráfico
    var arraykms = [
      ['Custo', 'Total']
    ];


    //Criando array com string=veículos e value=kms rodados
    for (var j = 1; j < iterator + 1; j++) {
      arraykeys.push(graph_expenses[j][1] + ' ' + graph_expenses[j][2] + ' ' + graph_expenses[j][3])
      arrayValues.push(default_list == 0 ? graph_expenses[j][4][0] : graph_expenses[j][4])
    }

    //Unindo arrays para popular gráficos
    for (var j = 0; j < iterator; j++) {
      arraykms.push([arraykeys[j], valueOrNull(parseFloat(default_list == 0 ? arrayValues[j] : arrayValues[j][0].km))])
    }

    google.charts.load('current', {
      'packages': ['corechart']
    });

    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable(arraykms);

      var options = {
        // title: graph_expenses[2][1] + ' ' + graph_expenses[2][2] + ' ' + graph_expenses[2][3],
        title: 'KM´s RODADOS',
        is3D: true,
      };

      var chart = new google.visualization.PieChart(document.getElementById('kmscharts'));

      chart.draw(data, options);
    }
    // }
  </script>

  <script type="text/javascript">
    var graph_vehicles = <?php echo $expenses; ?>;
    var iterator = Object.keys(graph_vehicles).length;

    google.charts.load('current', {
      'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    var arraydata = [
      ['Veículos', 'Combustível', 'Manutenção']
    ]

    for (var i = 1; i <= iterator; i++) {
      var fuel_consumed = graph_vehicles[i][7][0].fuel_consumed ? parseFloat(graph_vehicles[i][7][0].fuel_consumed) : 0
      var maintenance = graph_vehicles[i][6][0].maintenance ? parseFloat(graph_vehicles[i][6][0].maintenance) : 0
      arraydata.push([
        graph_vehicles[i][3], 
        fuel_consumed,
        maintenance
      ]);
    }

    function drawChart() {
      var data = google.visualization.arrayToDataTable(arraydata);

      var options = {
        chart: {
          title: 'Grafico de custos por veículo',
          subtitle: 'Combustível e manutenção',
        }
      };

      var chart = new google.charts.Bar(document.getElementById('costbykmcharts'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
  </script>
</body>

</html>
@stop