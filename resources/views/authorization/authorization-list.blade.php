@extends('layouts.application')

@section('content')

@if(!empty($successMsg))
<div class="alert alert-danger"> {{ $errorMsg }}</div>
@endif

@if (\Session::has('error'))<div class="ls-modal ls-opened" id="myAwesomeModal" role="dialog" aria-hidden="false" aria-labelledby="lsModal1" tabindex="-1">
  <div class="ls-modal-box">
    <div class="ls-modal-header">
      <h2 class="ls-modal-title" id="lsModal1"><strong>Atenção</strong></h2>
    </div>
    <div class="ls-modal-body">
      <h3 class="alert alert-danger">{!! \Session::get('error') !!}</h3>
    </div>
    <div class="ls-modal-footer">
      <button onclick="closeModal()" style="margin-bottom: 20px;" class="btn btn-danger ls-float-right">Fechar</button>
    </div>
  </div>
</div>
@endif
<script>
  function closeModal() {
    locastyle.modal.close()
  }
</script>

<!-- Chamada de DataTable e Estilos -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<h1 class="ls-title-intro ls-ico-code">Solicitações e Roteiros</h1>

<div class="col-md-12">
  <div class="col-md-6">
    <div class="ls-box">
      <b class="ls-title-5"><span style="color: red;"><?php echo DB::table('vehiclerequests')->where('statussolicitacao', 'PENDENTE')->count(); ?></span> - Solicitações pendentes</b>
      <hr>
      <!-- Tabela esquerda com Lista de todas as solcitações -->
      <table class="table table-hover" id="tableft">
        <thead>
          <tr>
            <th class="a-center" width="">Cod</th>
            <th class="a-center" width="100">Solicitante - Setor</th>
            <th class="a-center">Origem - Destino</th>
            <th class="a-center" width="60">Saída</th>
            <th class="a-center" width="25">Status</th>
          </tr>
        </thead>
        <tbody id="tbodyleft">
          <tr>
            <td></td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>
  <div class="col-md-6">
    <div class="ls-box">
      <!-- Tabela direita com lista de todos os roteiros -->
      <table class="table table-hover" id="tabright">
        <thead>
          <tr>
            <th width="">Cod</th>
            <th width="500">Motorista <br> Veículo</th>
            <th width="60">Saída <br> Retorno</th>
            <th>Autorizador</th>
            <th>Status</th>
            <th width="100">Ações</th>
          </tr>
        </thead>
        <tbody id="tbodyright">
        </tbody>
      </table>

      <div style="margin-top: 5px;" class="ls-float-right"><a onclick="resetScript()" class="ls-btn-primary ls-ico-spinner">Mostrar todos os roteiros</a></div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var requests = <?php echo $requests; ?>;
  var scriptauthorized = <?php echo $scriptauthorized; ?>;
  var countresquet = requests.length;
  var table = document.getElementById("tableft")[0];
  var sectors = <?php echo $sectors; ?>;
  var drivers = <?php echo $drivers; ?>;
  var vehicles = <?php echo $vehicles; ?>;
  var users = <?php echo $users; ?>;

  function nameSolicitante(solcitanteTablreResquessts) {
    var userNameOrInformed = ''

    function returnUser(item) {
      if (solcitanteTablreResquessts === item.id.toString()) {
        userNameOrInformed = item.name
      }
    }
    users.forEach(returnUser);

    if (userNameOrInformed == '') {
      userNameOrInformed = solcitanteTablreResquessts
    }

    return userNameOrInformed;
  }

  // Se o dia ou mês for menor que 10 será formatdo com um "0" a esquerda
  function checkTime(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }

  // Verifica o status da solicitação ou do roteiro e retorna uma cor para o style da coluna status das tabelas
  function colorSts(i) {
    if (i == "PENDENTE") {
      i = "red";
    } else if (i == "AUTORIZADA" || i == "AUTORIZADO") {
      i = "green";
    } else if (i == "REALIZADA" || i == "REALIZADO") {
      i = "Mediumaquamarine";
    } else {
      i = "blue";
    }
    return i;
  }

  // Recebe o identificador do setor e retorna com base no DB o nome do setor
  function sectorsName(codSector) {
    for (var j = 0; j <= sectors.length; j++) {
      if (codSector == sectors[j].cc) {
        return codSector = sectors[j].sector;
      }
    }
  }

  // Recebe o identificador do motorista e retorna com base no DB o nome do motorista
  function driverName(codDriver) {
    for (var j = 0; j <= drivers.length; j++) {
      if (codDriver == drivers[j].id) {
        return codDriver = drivers[j].name_driver;
      }
    }
  }

  // Recebe o identificador do veículo e retorna com base no DB as informações do veículo
  function vehicleInfo(codvehicle) {
    for (var j = 0; j <= vehicles.length; j++) {
      if (codvehicle == vehicles[j].id) {
        return codvehicle = "[" + vehicles[j].placa + "] " + vehicles[j].brand + " - " + vehicles[j].model;
      }
    }
  }

  function readOnlyAPart(text) {
    var readOnlyAPart = text.substring(0, 20) + "...";
    return readOnlyAPart;
  }

  // Reseta a Table de solicitações
  tbodyleft.innerHTML = '';

  // O "for" percorre o array de solicitações com base em seu tamanho
  for (var i = 0; i < countresquet; i++) {
    var datetime = new Date(requests[i].datasaida + "T" + requests[i].horasaida);
    var day = datetime.getDate();
    day = checkTime(day);
    var month = datetime.getMonth();
    month = checkTime(month + 1);
    var hour = datetime.getHours();
    hour = checkTime(hour);
    var minutes = datetime.getMinutes();
    minutes = checkTime(minutes);
    var seconds = datetime.getMinutes();
    seconds = checkTime(seconds);

    // Preenche a tabela esquerda com as solicitações 
    tbodyleft.innerHTML += `<tr onclick="showScript('` + requests[i].grouprequest + `')">` +
      `<td data-index="1">` + requests[i].id + `</td>` +
      "<td>" + readOnlyAPart(nameSolicitante(requests[i].solicitante)) + "<br>" + readOnlyAPart(sectorsName(requests[i].setorsolicitante)) + "</td>" +
      "<td>" + readOnlyAPart(requests[i].origem) + "<br>" + readOnlyAPart(requests[i].destino) + "</td>" +
      "<td>" + day + "/" + month + "/" + datetime.getFullYear() + "<br>" + hour + ":" + minutes + "</td>" +
      `<td style="color:` + colorSts(requests[i].statussolicitacao) + `; font-weight: bold;">` + requests[i].statussolicitacao + `</td>` +
      "</tr>";
  }

  // Reseta a Table de roteiros
  tbodyright.innerHTML = '';

  // O "for" percorre o array de roteiros com base em seu tamanho
  for (var k = 0; k < scriptauthorized.length; k++) {

    // DEPARTURE
    var datetime_departure = new Date(scriptauthorized[k].authorized_departure_date + "T" + scriptauthorized[k].authorized_departure_time);
    var day_departure = datetime_departure.getDate();
    day_departure = checkTime(day_departure);
    var month_departure = datetime_departure.getMonth();
    month_departure = checkTime(month_departure + 1);
    var hour_departure = datetime_departure.getHours();
    hour_departure = checkTime(hour_departure);
    var minutes_departure = datetime_departure.getMinutes();
    minutes_departure = checkTime(minutes_departure);
    var date_departure = day_departure + `/` + month_departure + `/` + datetime_departure.getFullYear() + `<br>` + `  ` + hour_departure + `:` + minutes_departure;

    // RETURN
    var datetime_return = new Date(scriptauthorized[k].return_date + "T" + scriptauthorized[k].return_time);
    var day_return = datetime_return.getDate();
    day_return = checkTime(day_return);
    var month_return = datetime_return.getMonth();
    month_return = checkTime(month_return + 1);
    var hour_return = datetime_return.getHours();
    hour_return = checkTime(hour_return);
    var minutes_return = datetime_return.getMinutes();
    minutes_return = checkTime(minutes_return);
    // console.log(day_return);

    var date_return;
    if(isNaN(day_return) && isNaN(month_return) && isNaN(hour_return) && isNaN(minutes_return)){
      date_return = '';
    } else {
      date_return = day_return + `/` + month_return + `/` + datetime_return.getFullYear() + `<br>` + `  ` + hour_return + `:` + minutes_return;
    }

    var buttons = '';
    var titleBtns = '';

    if (scriptauthorized[k].statusauthorization == 'REALIZADO') {

      buttons = `
      <div class="col-md-12">
        <a class="ls-ico-windows ls-btn" style="margin: 2px;" href="/authorization-pdf/` + scriptauthorized[k].id + `" target="_blank"></a>
      </div>`;
    } else {

      buttons = `
      <div class="col-md-6">
        <a class="ls-ico-pencil ls-btn-dark" style="background-color: blue; margin: 2px;" href="/authorization-edit/` + scriptauthorized[k].id + `"></a>
      </div>
      <div class="col-md-6">
        <a onclick="endScript('` + scriptauthorized[k].id + `', '` + scriptauthorized[k].itinerary + `')" class="ls-ico-checkbox-checked ls-btn-primary" style="margin: 2px;"></a>
      </div>
      <div class="col-md-6">
        <a class="ls-ico-remove ls-btn-primary-danger" style="margin: 2px;" href="/authorization/delete/` + scriptauthorized[k].id + `"></a>
      </div>
      <div class="col-md-6">
        <a class="ls-ico-windows ls-btn" style="margin: 2px;" href="/authorization-pdf/` + scriptauthorized[k].id + `" target="_blank"></a>
      </div>`;
    }

    // Preenche a tabela direita com os roteiros
    tbodyright.innerHTML += `<tr>` +
      `<td data-index="1">` + scriptauthorized[k].id + `</td>` +
      `<td>` + driverName(scriptauthorized[k].driver) + `<br>` + `  ` + vehicleInfo(scriptauthorized[k].vehicle) + `</td>` +
      `<td>` 
        + date_departure + `<br>`
        + `     ` + date_return + 
      `</td>` +
      `<td>` + scriptauthorized[k].authorizer + `</td>` +
      `<td style="color:` + colorSts(scriptauthorized[k].statusauthorization) + `; font-weight: bold;">` + scriptauthorized[k].statusauthorization + `</td>` +
      `<td>` +
      buttons +
      `</td>` +
      "</tr>";
  }

  // Ao clicar no botão "Mostrar todos os roteiros"
  function resetScript() {
    tbodyright.innerHTML = '';
    for (var k = 0; k < scriptauthorized.length; k++) {

      // DEPARTURE
      var datetime_departure = new Date(scriptauthorized[k].authorized_departure_date + "T" + scriptauthorized[k].authorized_departure_time);
      var day_departure = datetime_departure.getDate();
      day_departure = checkTime(day_departure);
      var month_departure = datetime_departure.getMonth();
      month_departure = checkTime(month_departure + 1);
      var hour_departure = datetime_departure.getHours();
      hour_departure = checkTime(hour_departure);
      var minutes_departure = datetime_departure.getMinutes();
      minutes_departure = checkTime(minutes_departure);
      var date_departure = day_departure + `/` + month_departure + `/` + datetime_departure.getFullYear() + `<br>` + `  ` + hour_departure + `:` + minutes_departure;

      // RETURN
      var datetime_return = new Date(scriptauthorized[k].return_date + "T" + scriptauthorized[k].return_time);
      var day_return = datetime_return.getDate();
      day_return = checkTime(day_return);
      var month_return = datetime_return.getMonth();
      month_return = checkTime(month_return + 1);
      var hour_return = datetime_return.getHours();
      hour_return = checkTime(hour_return);
      var minutes_return = datetime_return.getMinutes();
      minutes_return = checkTime(minutes_return);

      var date_return;
      if(isNaN(day_return) && isNaN(month_return) && isNaN(hour_return) && isNaN(minutes_return)){
        date_return = '';
      } else {
        date_return = day_return + `/` + month_return + `/` + datetime_return.getFullYear() + `<br>` + `  ` + hour_return + `:` + minutes_return;
      }

      var buttons = '';
      var titleBtns = '';

      if (scriptauthorized[k].statusauthorization == 'REALIZADO') {

        buttons = `
          <div class="col-md-12">
            <a class="ls-ico-windows ls-btn" style="margin: 2px;" href="/authorization-pdf/` + scriptauthorized[k].id + `" target="_blank"></a>
          </div>`;
      } else {

        buttons = `
          <div class="col-md-6">
            <a class="ls-ico-pencil ls-btn-dark" style="background-color: blue; margin: 2px;" href="/authorization-edit/` + scriptauthorized[k].id + `"></a>
          </div>
          <div class="col-md-6">
            <a onclick="endScript('` + scriptauthorized[k].id + `', '` + scriptauthorized[k].itinerary + `')" class="ls-ico-checkbox-checked ls-btn-primary" style="margin: 2px;"></a>
          </div>
          <div class="col-md-6">
            <a class="ls-ico-remove ls-btn-primary-danger" style="margin: 2px;" href="/authorization/delete/` + scriptauthorized[k].id + `"></a>
          </div>
          <div class="col-md-6">
            <a class="ls-ico-windows ls-btn" style="margin: 2px;" href="/authorization-pdf/` + scriptauthorized[k].id + `" target="_blank"></a>
          </div>`;
      }

      tbodyright.innerHTML += `<tr>` +
        `<td data-index="1">` + scriptauthorized[k].id + `</td>` +
        `<td>` + driverName(scriptauthorized[k].driver) + `<br>` + `  ` + vehicleInfo(scriptauthorized[k].vehicle) + `</td>` +
        `<td>` 
          + date_departure + `<br>`
          + `     ` + date_return + 
        `</td>` +
        `<td>` + scriptauthorized[k].authorizer + `</td>` +
        `<td style="color:` + colorSts(scriptauthorized[k].statusauthorization) + `; font-weight: bold;">` + scriptauthorized[k].statusauthorization + `</td>` +
        `<td>` +
        buttons +
        `</td>` +
        "</tr>";
    }
  }

  // Ao clicar em uma solicitação ela irá exibir o roteiro em que está vinculada na tabela direita.
  function showScript(script) {
    tbodyright.innerHTML = '';
    for (var k = 0; k < scriptauthorized.length; k++) {

      // DEPARTURE
      var datetime_departure = new Date(scriptauthorized[k].authorized_departure_date + "T" + scriptauthorized[k].authorized_departure_time);
      var day_departure = datetime_departure.getDate();
      day_departure = checkTime(day_departure);
      var month_departure = datetime_departure.getMonth();
      month_departure = checkTime(month_departure + 1);
      var hour_departure = datetime_departure.getHours();
      hour_departure = checkTime(hour_departure);
      var minutes_departure = datetime_departure.getMinutes();
      minutes_departure = checkTime(minutes_departure);
      var date_departure = day_departure + `/` + month_departure + `/` + datetime_departure.getFullYear() + `<br>` + `  ` + hour_departure + `:` + minutes_departure;

      // RETURN
      var datetime_return = new Date(scriptauthorized[k].return_date + "T" + scriptauthorized[k].return_time);
      var day_return = datetime_return.getDate();
      day_return = checkTime(day_return);
      var month_return = datetime_return.getMonth();
      month_return = checkTime(month_return + 1);
      var hour_return = datetime_return.getHours();
      hour_return = checkTime(hour_return);
      var minutes_return = datetime_return.getMinutes();
      minutes_return = checkTime(minutes_return);

      var date_return;
      if(isNaN(day_return) && isNaN(month_return) && isNaN(hour_return) && isNaN(minutes_return)){
        date_return = '';
      } else {
        date_return = day_return + `/` + month_return + `/` + datetime_return.getFullYear() + `<br>` + `  ` + hour_return + `:` + minutes_return;
      }

      var buttons = '';
      var titleBtns = '';

      if (scriptauthorized[k].statusauthorization == 'REALIZADO') {

        buttons = `
      <div class="col-md-12">
        <a class="ls-ico-windows ls-btn" style="margin: 2px;" href="/authorization-pdf/` + scriptauthorized[k].id + `" target="_blank"></a>
      </div>`;
      } else {

        buttons = `
      <div class="col-md-6">
        <a class="ls-ico-pencil ls-btn-dark" style="background-color: blue; margin: 2px;" href="/authorization-edit/` + scriptauthorized[k].id + `"></a>
      </div>
      <div class="col-md-6">
        <a onclick="endScript('` + scriptauthorized[k].id + `', '` + scriptauthorized[k].itinerary + `')" class="ls-ico-checkbox-checked ls-btn-primary" style="margin: 2px;"></a>
      </div>
      <div class="col-md-6">
        <a class="ls-ico-remove ls-btn-primary-danger" style="margin: 2px;" href="/authorization/delete/` + scriptauthorized[k].id + `"></a>
      </div>
      <div class="col-md-6">
        <a class="ls-ico-windows ls-btn" style="margin: 2px;" href="/authorization-pdf/` + scriptauthorized[k].id + `" target="_blank"></a>
      </div>`;
      }

      if (script == scriptauthorized[k].itinerary) {
        tbodyright.innerHTML = `<tr>` +
          `<td data-index="1">` + scriptauthorized[k].id + `</td>` +
          `<td>` + driverName(scriptauthorized[k].driver) + `<br>` + `  ` + vehicleInfo(scriptauthorized[k].vehicle) + `</td>` +
          `<td>` 
            + date_departure + `<br>`
            + `     ` + date_return + 
          `</td>` +
          `<td>` + scriptauthorized[k].authorizer + `</td>` +
          `<td style="color:` + colorSts(scriptauthorized[k].statusauthorization) + `; font-weight: bold;">` + scriptauthorized[k].statusauthorization + `</td>` +
          `<td>` +
          buttons +
          `</td>` +
          "</tr>";
      }
    }
  }
</script>

<!-- Exibe as opções de Datatables nas tabelas -->
<script type="text/javascript">
  $(document).ready(function() {
    $('#tabright').DataTable({
   "order": [[ 0, "desc" ]],
      dom: 'Bfrtip',
      buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
      ]
    });
    $('#tableft').DataTable({
   "order": [[ 0, "desc" ]],
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
  function endScript($id, $itinerary) {
    $('#id').val($id);

    locastyle.modal.open("#modalLarge");

    // Pga os ID's das solicitações deste roteiro
    var arr = [];

    // Transforma array 'arr[]' em string
    function countRequestInScript(scriptAuth) {
      if (scriptAuth.id == $id) {
        function countRequest(requestAuth) {
          if (requestAuth.grouprequest == scriptAuth.itinerary && scriptAuth.arr_requests_in_script.indexOf(requestAuth.id) > -1) {
            arr.push(requestAuth.id);
          }
        }
        requests.forEach(countRequest);
      }
    }
    scriptauthorized.forEach(countRequestInScript);
  }
</script>

<div class="ls-modal" id="modalLarge">
  <div class="ls-modal-large">
    <div class="ls-modal-header">
      <button data-dismiss="modal">&times;</button>
      <h4 class="ls-modal-title">Finalizar viagem</h4>
    </div>
    <div class="ls-modal-body">
      <form method="POST" action="{{url()->current()}}" lass="ls-form row" id="add">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <input type="hidden" id="id" name="id">
        <fieldset id="field01">
          <div class="col-md-12">
            <div class="ls-box">
              <div class="col-md-12">
                <div class="col-md-6">
                  <b class="ls-label-text">Data de retorno</b>
                  <input type="date" class="form-control" name="dataretorno" required oninvalid="this.setCustomValidity('Informe a data de retorno do veículo!')" onchange="try{setCustomValidity('')}catch(e){}">
                </div>
                <div class="form-group col-md-6">
                  <b class="ls-label-text">Hora de retorno</b>
                  <input type="time" class="form-control" name="horaretorno" required oninvalid="this.setCustomValidity('Informe o horário de retorno do veículo!')" onchange="try{setCustomValidity('')}catch(e){}">
                </div>

                <div class="form-group col-md-6" style="margin-bottom: 20px;">
                  <b class="ls-label-text" style="color: red;">Quilometragem inicial</b>
                  <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" id="kminicial" name="kminicial" maxlength="6" autocomplete="off" required oninvalid="this.setCustomValidity('Informe a quilometragem inicial!')" onchange="try{setCustomValidity('')}catch(e){}">
                </div>
                <div class="form-group col-md-6">
                  <b class="ls-label-text" style="color: red;">Quilometragem final</b>
                  <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" id="kmfinal" name="kmfinal" maxlength="6" autocomplete="off" required>
                  <script>
                    function kmValidation() {
                      var kminicial = document.getElementById("kminicial");
                      var kmfinal = document.getElementById("kmfinal");
                      var result = kmfinal.value - kminicial.value;
                      if (kmfinal.value <= kminicial.value) {
                        kmfinal.setCustomValidity("A quilometragem final precisa ser maior que a inicial");
                      } else {
                        kmfinal.setCustomValidity("");
                      }
                      if (result >= 251) {
                        kmfinal.setCustomValidity("Valor a cima do limite! Verifique se o valor está correto ou entre em contato com o suporte.");
                      }
                    }

                    function validateDateTimeReturn() {

                    }
                  </script>
                </div>
              </div>
            </div>
          </div>
          <div>
            <button style="margin: 20px;" class="btn btn-danger ls-float-right" data-dismiss="modal" type="button">Cancelar</button>
            <button onclick="kmValidation()" style="margin: 20px;" type="submit" class="ls-btn-primary">Salvar roteiro</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

@endsection