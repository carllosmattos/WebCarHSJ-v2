@extends('layouts.application')

@section('content')

<html>

<head>
  <title>Controle Setor</title>
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
  <br />

  <h1 class="ls-title-intro ls-ico-chart-bar-up">Custos por setor</h1>
  <div class="ls-box">
    <div class="col-md-12">
      <div class="col-md-12">
        <div class="box-header">
          <form method="post" action="{{ route('sector-cost') }}" class="form form-inline">
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
                  <a class="ls-btn-primary-danger" href="/sector-cost">Limpar</a>
                </div>
              </label>
            </fieldset>
          </form>
        </div>

        <div class="col-md-12">
          <div id="table">
            <table id="cost-by-sectors" class="display">
              <thead>
                <th>&nbsp;</th>
                <th>Setor</th>
                <th>Km's rodados()</th>
                <th>Combustível gasto(R$)</th>
                <th>Manutenção(R$)</th>
              </thead>
              <tbody id="tbody">
                <tr>
                  <td>Carlos</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div id="chartCol" style="width: 900px; height: 500px;"></div>
      </div>
      <div class="col-md-6">
        <div id="chartCol2" style="width: 900px; height: 500px;"></div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    var sectors = <?php echo $expense_sectors ?>;
    var default_list = <?php echo $default_list ?>;
    var count = Object.keys(sectors).length;
    var table = document.getElementById("cost-by-sectors")[0];
    console.log(sectors);

    // limpar tbody

    tbody.innerHTML = "";

    // function decimalView(val){
    //   return val.toFixed()
    // }

    //adicionar as linha na tabela
    for (var i = 1; i <= count; i++) {
      tbody.innerHTML += "<tr><td>" + [i] + "</td>" +
        "<td>" + sectors[i][2] +
        "</td><td>" + (default_list == 1 ? (sectors[i][3][0].km ? sectors[i][3][0].km : '0.00') : (sectors[i][3] ? sectors[i][3] : '0.00')) + "</td>" +
        "</td><td>" + (default_list == 1 ? (sectors[i][4][0].spent ? sectors[i][4][0].spent : '0.00') : (sectors[i][4] ? sectors[i][4] : '0.00')) + "</td>" +
        "</td><td>" + parseFloat(default_list == 1 ? (sectors[i][8]? sectors[i][8] : '0.00') : (sectors[i][7] ? sectors[i][7] : '0.00')).toFixed(2) + "</td>" +
        "</tr>";
    }
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#cost-by-sectors').DataTable({
        dom: 'Bfrtip',
        buttons: [
          'copyHtml5',
          'excelHtml5',
          'csvHtml5',
          'pdfHtml5'
        ]
      });
    });
  </script>

  <script type="text/javascript">
    var graph_sectors_km = <?php echo $expense_sectors; ?>;
    var iterator = Object.keys(graph_sectors_km).length;
    var arraykeys = [];
    var arrayValues = [];

    google.charts.load("current", {
      packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    var arraydata = [
      ['Setor', 'Quilometros rodados'],
    ]

    for (var i = 1; i <= count; i++) {
      arraykeys.push(graph_sectors_km[i][2])
      arrayValues.push(default_list == 1 ? (graph_sectors_km[i][3][0].km ? graph_sectors_km[i][3][0].km : 0) : (graph_sectors_km[i][3][0] ? graph_sectors_km[i][3][0] : 0))
    }

    for (var i = 0; i < iterator; i++) {
      arraydata.push([arraykeys[i], parseFloat(arrayValues[i])])
    }


    function drawChart() {
      var data = google.visualization.arrayToDataTable(arraydata);

      var options = {
        title: 'Quilometros rodados(Km)',
        is3D: true,
      };

      var chart = new google.visualization.PieChart(document.getElementById('chartCol'));
      chart.draw(data, options);
    }
  </script>

  <script type="text/javascript">
    var graph_sectors_spent = <?php echo $expense_sectors; ?>;
    var it = Object.keys(graph_sectors_spent).length;
    var arraykeys2 = [];
    var arrayValues2 = [];

    google.charts.load("current", {
      packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    var arraydata2 = [
      ['Setor', 'Combutível gasto'],
    ]

    for (var i = 1; i <= it; i++) {
      arraykeys2.push(graph_sectors_spent[i][2])
      arrayValues2.push(default_list == 1 ? (graph_sectors_spent[i][4][0].spent ? graph_sectors_spent[i][4][0].spent : 0) : (graph_sectors_spent[i][4][0] ? graph_sectors_spent[i][4][0] : 0))
    }

    for (var i = 0; i < it; i++) {
      arraydata2.push([arraykeys2[i], parseFloat(arrayValues2[i])])
    }

    function drawChart() {
      var data = google.visualization.arrayToDataTable(arraydata2);

      var options = {
        title: 'Custo combustível(R$)',
        pieHole: 0.6,
      };

      var chart = new google.visualization.PieChart(document.getElementById('chartCol2'));
      chart.draw(data, options);
    }
  </script>


</body>

</html>
@stop