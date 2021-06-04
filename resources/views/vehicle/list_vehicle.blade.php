@extends('layouts.application')

@section('content')

<h1 class="ls-title-intro ls-ico-dashboard">Lista de Veiculos</h1>
<div class="ls-box">

  <table id="tablevehicles" class="table table-hover">
    <thead>
      <tr>
        <th>Ordem</th>
        <th width="150">Motorista</th>
        <th>Veículo</th>
        <th>Placa</th>
        <th>Ano</th>
        <th>Consumo(KM/L)</th>
        <th>Último preço do combustível</th>
        <th>Situação do veiculo</th>
        <th width="150">Ação</th>
      </tr>
    </thead>
    <tbody id="tbodyvehicles">
      <tr>
        <td></td>
      </tr>
      <!-- <div class="ls-alert-danger">Não dados para exibir</div> -->
    </tbody>
  </table>

</div>

<script>
  var vehicles = <?php echo $vehicles; ?>;
  var drivers = <?php echo $drivers; ?>;
  var tbodyvehicles = document.getElementById("tbodyvehicles");

  function driverName(driver_id) {
    for (var i = 0; i < drivers.length; i++) {
      if (drivers[i].id == driver_id) {
        return drivers[i].name_driver;
      }
    }
  }

  function styleSituacao(style) {
    var fontWeight = 'font-weight: bold;'
    if (style == 'LIVRE') {
      return 'color: green; ' + fontWeight;
    } else if (style == 'EM MANUTENÇÂO') {
      return 'color: red; ' + fontWeight;
    } else {
      return 'color: blue; ' + fontWeight;
    }
  }


  // Reseta a Table de solicitações
  tbodyvehicles.innerHTML = '';
  // O "for" percorre o array de solicitações com base em seu tamanho
  for (var i = 0; i < vehicles.length; i++) {
    tbodyvehicles.innerHTML +=
      `<tr>` +
      `<td>` + [i + 1] + `</td>` +
      `<td>` + driverName(vehicles[i].driver_id) + `</td>` +
      `<td>` + vehicles[i].brand + ` - ` + vehicles[i].model + `</td>` +
      `<td>` + vehicles[i].placa + `</td>` +
      `<td>` + vehicles[i].year + `</td>` +
      `<td>` + vehicles[i].kilometers_per_liter + `</td>` +
      `<td>` + parseFloat(vehicles[i].last_price).toFixed(3) + `</td>` +
      `<td style="` + styleSituacao(vehicles[i].situacao) + `">` + vehicles[i].situacao + `</td>` +
      `<td>` +

      `<a class="ls-ico-pencil ls-btn-dark" style="background-color: blue;" href="vehicle/edit/` + vehicles[i].id + `"></a>
          <a class="ls-ico-remove ls-btn-primary-danger" href="vehicle/delete/` + vehicles[i].id + `"></a>
          <a class="ls-ico-stats ls-btn-primary" href="/expense/add?` + vehicles[i].id + `"></a>` +

      `</td>` +
      `</tr>`;
  }
</script>

<script>
  $(document).ready(function() {
    $('#tablevehicles').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        {
          extend: 'pdfHtml5',
          orientation: 'landscape',
        }
      ]
    });
  });
</script>
@stop