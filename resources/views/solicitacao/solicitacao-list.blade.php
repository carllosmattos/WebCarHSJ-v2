@extends('layouts.application')

@section('content')

<h1 class="ls-title-intro ls-ico-code">Lista de Solicitações</h1>

@if(isset($msg))
<div class="alert alert-success">
  {{$msg}}
</div>
@endif

@if($vehiclerequests == false)
<div class="alert alert-danger" role="alert">
  Não há solicitações para exibir!
</div>
@else
<table class="table table-hover" id="tabRequests">
  <thead>
    <tr>
      <th width="15">Ordem</th>
      <th>Cod</th>
      <th>Solicitante</th>
      <th>setor</th>
      <th>Origem - Destino</th>
      <th>Data e hora de saída</th>
      <th>Status</th>
      <th width="240">Ações</th>
    </tr>
  </thead>
  <tbody id="tbodyrequests">
    <tr>
      <td></td>
    </tr>
  </tbody>
</table>
@endif

<script type="text/javascript">
  var requests = <?php echo $requests; ?>;
  var sectors = <?php echo $sectors; ?>;
  var users = <?php echo $users; ?>;

  function nameSolicitante(solcitanteTablreResquessts) {
    var userNameOrInformed = ''

    function returnUser(item) {
      if (solcitanteTablreResquessts === item.id.toString()) {
        userNameOrInformed = item.name
      }
    }
    users.forEach(returnUser);
    
    if(userNameOrInformed == ''){
      userNameOrInformed = solcitanteTablreResquessts
    }

    return userNameOrInformed;
  }

  // Recebe o identificador do setor e retorna com base no DB o nome do setor
  function sectorsName(codSector) {
    for (var j = 0; j <= sectors.length; j++) {
      if (codSector == sectors[j].cc) {
        return codSector = sectors[j].sector;
      }
    }
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

  // Reseta a Table de solicitações
  tbodyrequests.innerHTML = '';
  // O "for" percorre o array de solicitações com base em seu tamanho
  for (var i = 0; i < requests.length; i++) {

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

    function actionEditAndDeleteAnd(sts) {
      if (requests[i].statussolicitacao == 'PENDENTE') {
        sts = `<div class="col-md-4">
                <a class="ls-ico-pencil ls-btn-dark" style="background-color: blue;" href="/solicitacao-edit/` + requests[i].id + `"></a>
              </div>
              <div class="col-md-4">
                <a class="ls-ico-remove ls-btn-primary-danger" href="/solicitacao/delete/ ` + requests[i].id + `"></a>
              </div>
              <div class="col-md-4">
                <a class="ls-ico-windows ls-btn" href="/request-vehicle-pdf/` + requests[i].id + `" target="_blank"></a>
              </div>`;
        return sts;
      } else if (requests[i].statussolicitacao == 'NÃO REALIZADA') {
        sts = `<div class="col-md-4">
                <a class="ls-ico-pencil ls-btn-dark" style="background-color: blue;" href="/solicitacao-edit/` + requests[i].id + `"></a>
              </div>
              <div class="col-md-4">
                <a class="ls-ico-remove ls-btn-primary-danger" href="/solicitacao/delete/ ` + requests[i].id + `"></a>
              </div>
              <div class="col-md-4">
                <a class="ls-ico-windows ls-btn" href="/request-vehicle-pdf/` + requests[i].id + `" target="_blank"></a>
              </div>`;
        return sts;
      } else {
        sts = `<div class="col-md-4">
              </div>
              <div class="col-md-4">
              </div>
              <div class="col-md-4">
                <a class="ls-ico-windows ls-btn" href="/request-vehicle-pdf/` + requests[i].id + `" target="_blank"></a>
              </div>`;
        return sts;
      }
    }

    // Preenche a tabela esquerda com as solicitações 
    tbodyrequests.innerHTML += `<tr onclick="showScript('` + requests[i].grouprequest + `')">` +
      "<td>" + [i + 1] + "</td>" +
      `<td data-index="1">` + requests[i].id + `</td>` +
      "<td>" + nameSolicitante(requests[i].solicitante) + "</td>" +
      "<td>" + sectorsName(requests[i].setorsolicitante) + "</td>" +
      "<td>" + requests[i].origem + "<br>" + requests[i].destino + "</td>" +
      "<td>" + day + "/" + month + "/" + datetime.getFullYear() + "<br>" + hour + ":" + minutes + "</td>" +
      `<td style="color:` + colorSts(requests[i].statussolicitacao) + `; font-weight: bold;">` + requests[i].statussolicitacao + `</td>` +
      `<td>
        <div class="col-12">` +
      actionEditAndDeleteAnd(requests[i].statussolicitacao); +
    `</div>
      </td>` +
    "</tr>";
  }
</script>

<!-- Exibe as opções de Datatables nas tabelas -->
<script type="text/javascript">
  $(document).ready(function() {
    $('#tabRequests').DataTable({
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
@endsection