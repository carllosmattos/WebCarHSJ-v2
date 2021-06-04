@extends('layouts.application')

@section('content')
<h1 class="ls-title-intro ls-ico-code">Solicitar Veiculo</h1>

<form method="POST" action="{{ route('solicitacao.postEdit', $vehiclerequest->id) }}" class="ls-form row" id="add">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <fieldset id="field01">
        <div class="ls-box">
            <div class="col-md-12">
                <div class="ls-box">
                    <div class="col-md-6">
                        <h5 class="ls-title-5">Solicitante</h5>
                        <hr>
                        <div class="form-group col-md-12">
                            <b class="ls-label-text col-md-4">Nome do Solicitante</b>
                            <div class="col-md-3">
                                <b style="color: red;" class="ls-label-text">Não encontrou na lista?</b>
                                <input onchange="verifyCheck()" type="checkbox" id="checkSolicitante"
                                @if(intval($vehiclerequest->solicitante) == 0)
                                checked
                                @endif
                                nome="subscribe" value="">
                            </div>
                            <div id="input"></div>
                        </div>

                        <script>
                            var input = document.getElementById('input');
                            var solicitante = <?php echo intval($vehiclerequest->solicitante); ?>;
                            var checkSolicitante = document.getElementById("checkSolicitante");
                            var inputSolicitante = `<input type="text" class="form-control col-md-12" 
                            name="solicitante" id="inputSolicitante" placeholder="Digite o nome do solicitante" 
                            oninvalid="this.setCustomValidity('Informe o nome do solicitante deste roteiro!')" 
                            onchange="try{setCustomValidity('')}catch(e){}" value="{{$vehiclerequest->solicitante}}" required>`;

                            var selectSolicitante = `<select id="selectSolicitante" name="solicitante" class="ls-select form-control col-md-12" 
                             oninvalid="this.setCustomValidity('Selecione o usuário!')" onchange="try{setCustomValidity('')}catch(e){}" required>
                                @inject('users', '\App\User')
                                @foreach($users->getUsers() as $users)
                                <option value="{{$users->id}}" class=" form-control" 
                                    @if($users->id == $vehiclerequest->solicitante)
                                    selected
                                    @endif
                                >{{$users->name}}</option>
                                @endforeach
                            </select>`;

                            if (solicitante == 0) {
                                input.innerHTML = '';
                                input.innerHTML = inputSolicitante;
                                checkSolicitante.checked == true;
                            } else {
                                input.innerHTML = '';
                                input.innerHTML = selectSolicitante;
                                checkSolicitante.checked == false;
                            }

                            function verifyCheck() {
                                input.innerHTML = '';
                                if (checkSolicitante.checked == true) {
                                    input.innerHTML = inputSolicitante;
                                } else if (checkSolicitante.checked == false) {
                                    input.innerHTML = selectSolicitante;
                                }
                            }
                        </script>

                        <div class="form-group col-md-12">
                            <b class="ls-label-text">Setor Solicitante</b>
                            <div class="ls-custom-select">
                                <select id="setorsolicitante[0]" name="setorsolicitante" class="ls-select form-control" required>
                                    @inject('sectors', '\App\Sector')
                                    @foreach($sectors->getSectors() as $sectors)
                                    <option value="{{$sectors->cc}}" @if($vehiclerequest->setorsolicitante == $sectors->cc) selected @else @endif class=" form-control">{{$sectors->cc}} - {{$sectors->sector}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h5 class="ls-title-5">Seu Roteiro</h5>
                        <hr>
                        <div class="form-group col-md-12">
                            <b class="ls-label-text">Origem</b>
                            <input list="wizards-origem[0]" type="text" id="txtOrigem[0]" oninput="mapear(0)" class="form-control" name="origem" value="{{$vehiclerequest->origem}}" placeholder="Ex.: R. Nestor Barbosa, 315 - Parquelândia, Fortaleza - CE, 60455-610" required oninvalid="this.setCustomValidity('Informe o local de origem da sua solicitação!')" onchange="try{setCustomValidity('')}catch(e){}">
                            <input type="hidden" id="origemValid[0]" name="origemValid[0]" />

                            <datalist style="display: none;" id="wizards-origem[0]">
                            </datalist>
                        </div>

                        <div class="form-group col-md-12">
                            <b class="ls-label-text">Destino</b>
                            <input list="wizards-destino[0]" type="text" id="txtDestino[0]" oninput="mapear(0)" class="form-control" name="destino" value="{{$vehiclerequest->destino}}" placeholder="Ex.: Av. Almirante Barroso, 600 - Praia de Iracema, Fortaleza - CE, 60060-440" required oninvalid="this.setCustomValidity('Informe o destino da sua solicitação!')" onchange="try{setCustomValidity('')}catch(e){}">
                            <input type="hidden" id="destinoValid[0]" name="destinoValid[0]" />

                            <datalist id="wizards-destino[0]">
                            </datalist>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="ls-title-5">Confirme seu roteiro</h5>
                        <hr>
                        <iframe id="map[0]" width="100%" scrolling="no" height="330" frameborder="0" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?saddr={{$vehiclerequest->origem}}&daddr={{$vehiclerequest->destino}}&output=embed"></iframe>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div style="margin-top: 15px;" class="ls-box">
                    <h5 class="ls-title-5">Finalidade</h5>
                    <hr>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Transporte de pacientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Transporte de materiais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Necessidades administrativas</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="ls-box">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <b class="ls-label-text">Unidade</b>
                                            <input id="unidade" type="text" class="form-control" name="unidade" value="{{$vehiclerequest->unidade}}" placeholder="Ex.: Unidade D" required oninvalid="this.setCustomValidity('Informe a unidade!')" onchange="try{setCustomValidity('')}catch(e){}">
                                            <b class="ls-label-text">Leito</b>
                                            <input id="leito" type="number" class="form-control" name="leito" value="{{$vehiclerequest->leito}}" placeholder="Este campo só aceita números Ex.: 2" required oninvalid="this.setCustomValidity('Informe o leito!')" onchange="try{setCustomValidity('')}catch(e){}">
                                        </div>
                                        <div class="form-group">
                                            <b class="ls-label-text">Motivo da solicitação</b>
                                            <div class="ls-custom-select">
                                                <select id="sltmotivo" name="sltmotivo" class="ls-select form-control" required>
                                                    <option @if($vehiclerequest->sltmotivo == "Alta") selected @else @endif value="Alta">Alta</option>
                                                    <option @if($vehiclerequest->sltmotivo == "Transferência") selected @else @endif value="Transferência">Transferência</option>
                                                    <option @if($vehiclerequest->sltmotivo == "Remoção") selected @else @endif value="Remoção">Remoção</option>
                                                    <option @if($vehiclerequest->sltmotivo == "Retorno") selected @else @endif value="Retorno">Retorno</option>
                                                    <option @if($vehiclerequest->sltmotivo == "Exame com retorno") selected @else @endif value="Exame com retorno">Exame com retorno</option>
                                                    <option @if($vehiclerequest->sltmotivo == "Exame sem retorno") selected @else @endif value="Exame sem retorno">Exame sem retorno</option>
                                                    <option @if($vehiclerequest->sltmotivo == "Outro") selected @else @endif value="Outro">Outro</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <b class="ls-label-text">Condições/outros</b>
                                        <textarea id="estadopaciente" placeholder="Condições de locomoção de paciente ou outros motivos da solicitação" 
                                        name="estadopaciente" cols="75" rows="7" value="{{$vehiclerequest->estadopaciente}}"
                                        required oninvalid="this.setCustomValidity('Descreva as condições de locomoção de paciente ou outros motivos da solicitação!')" 
                                        onchange="try{setCustomValidity('')}catch(e){}">{{$vehiclerequest->estadopaciente}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="ls-box">
                                <div class="col-md-12">
                                    <b class="ls-label-text">Descreva os materiais a serem transportados</b>
                                    <textarea id="materiais-fin" class="form-control" rows="5" name="materiaisfin" 
                                    placeholder="Descreva a lista de materiais a serem transportados e se há alguma documentação assinada." 
                                    disabled required oninvalid="this.setCustomValidity('Descreva os materiais a serem transferidos!')" 
                                    onchange="try{setCustomValidity('')}catch(e){}">{{$vehiclerequest->materiaisfin}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <div class="ls-box">
                                <div class="col-md-12">
                                    <b class="ls-label-text">Descreva o motivo da solicitação</b>
                                    <textarea id="adm-fin" class="form-control" rows="3" name="admfin" 
                                    placeholder="Ex.: Reunião" disabled required 
                                    oninvalid="this.setCustomValidity('Descreva o motivo da solicitação!')" 
                                    onchange="try{setCustomValidity('')}catch(e){}">{{$vehiclerequest->admfin}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div style="margin-top: 15px;" class="ls-box">
                    <h5 class="ls-title-5">Agendamento</h5>
                    <hr>
                    <div class="form-group col-md-4">
                        <b class="ls-label-text">Data do saída</b>
                        <input type="date" class="form-control" name="datasaida" value="{{$vehiclerequest->datasaida}}" required oninvalid="this.setCustomValidity('Informe a data que pretende sair!')" onchange="try{setCustomValidity('')}catch(e){}">
                    </div>
                    <div class="form-group col-md-4">
                        <b class="ls-label-text">Hora do saída</b>
                        <input type="time" class="form-control" name="horasaida" value="{{$vehiclerequest->horasaida}}" required oninvalid="this.setCustomValidity('Informe o horário que pretende sair!')" onchange="try{setCustomValidity('')}catch(e){}">
                    </div>
                    <h5 style="color: red;" class="ls-title-5 col-md-12">Informe uma previsão de retorno caso necessite</h5>
                    <div class="form-group col-md-4">
                        <b class="ls-label-text">Data do retorno</b>
                        <input type="date" class="form-control" name="dataretorno" value="{{$vehiclerequest->dataretorno}}">
                    </div>
                    <div class="form-group col-md-4">
                        <b class="ls-label-text">Hora do retorno</b>
                        <input type="time" class="form-control" name="horaretorno" value="{{$vehiclerequest->horaretorno}}">
                    </div>
                </div>
            </div>
        </div>
        <b id="form2"></b>
        <b id="form3"></b>
        <b id="form4"></b>
    </fieldset>
    <div class="col-md-12">
        <div class="jumbotron">
            <div align="right" style="font-weight: bold;">
                <input type="submit" value="Salvar Alterações" class="ls-btn-primary" title="Editar" style="font-weight: bold;">
                <a class="ls-btn-primary-danger" style="font-weight: bold;" href="{{ route('solicitacoes') }}">Cancelar</a>
            </div>
        </div>
    </div>
</form>

<!-- ////////////////////////////////////////// Moldais -->
<div class="ls-modal" id="registerNewAddress">
    <div class="ls-modal-large">
        <div class="ls-modal-header">
            <button data-dismiss="modal">&times;</button>
            <h4 class="ls-modal-title">O Endereço que procura não está na lista de sugestões? <br>
                Cadastre um novo endereço para que ele esteja disponível em suas próximas solicitações</h4>
        </div>
        <div class="ls-modal-body" style="height: 250px;">
            <div class="col-md-12">
                <label class="col-md-3">
                    <b>Nome do local</b>
                    <input id="acronym" class="col-md-12" type="text" placeholder="Hospital São José ou HSJ" required>
                    <div id="acronymMessageError" class="ls-alert-danger"></div>
                </label>
                <div class="col-md-7">
                    <b>Endereço</b>
                    <input id="publicPlace" class="col-md-12" type="text" placeholder="R. Nestor Barbosa" required>
                    <div id="publicPlaceMessageError" class="ls-alert-danger"></div>
                </div>
                <div class="col-md-2">
                    <b>Número</b>
                    <input id="numberPoint" class="col-md-12" type="number" min="1" placeholder="315">
                    <div id="numberPointMessageError" class="ls-alert-danger"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <b>Bairro</b>
                    <input id="neighborhood" class="col-md-12" type="text" placeholder="Parquelândia" required>
                    <div id="neighborhoodMessageError" class="ls-alert-danger"></div>
                </div>
                <div class="col-md-6">
                    <b>Cidade</b>
                    <input id="city" class="col-md-12" type="text" placeholder="Fortaleza" required>
                    <div id="cityMessageError" class="ls-alert-danger"></div>
                </div>
                <div class="col-md-12">
                    <button style="margin: 10px 0;" onclick="verifyAddress()" class="ls-btn-primary">Verifique o endereço</button>
                </div>
                <div>
                    <div class="col-md-12" id="mapValidate">
                        <iframe style="margin-top: 10px;" width="100%" scrolling="no" height="330" frameborder="0" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?saddr=HSJ&daddr=&output=embed"></iframe>
                    </div>
                    <div class="col md-12">
                        <div class="col-md-12">
                            <b>O endereço que você digitou é o mesmo mostrado no mapa?</b>
                        </div>
                        <div class="col-md-12">
                            <input type="checkbox" id="confirmeEqualsAdress" name="confirmeEqualsAdress" required>
                            <label><b>SIM</b></label>
                            <div id="confirmeEqualsAdressMessageError" class="ls-alert-danger"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ls-modal-footer">
                <button style="margin: 20px 0;" onclick="dismissModal($inputForm)" class="ls-btn-primary-danger ls-float-right">Fechar</button>
                <button style="margin: 20px 0;" onclick="setInputValueForm($inputForm, $inputValidForm)" class="ls-btn-primary">Salvar endereço</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Utilizado no código confirmeroute.js
    var adressServ = <?php echo $adress ?>;

    var listOptions = [];
    for (var i in adressServ) {
        listOptions.push(adressServ[i].slug_adress);
    }

    regex = new RegExp('\\b' + listOptions.join("\\b|\\b") + '\\b', 'i');
    //////////////////////////////////////////////////////////////////////////
</script>

<!-- Pegando collections laravel para variável. Variável é utilizada em script js/solicitacaoedittab.js -->
<script>
    var requestcar = <?php echo $vehiclerequest; ?>
</script>
<script type="text/javascript" src="{{ URL::asset('js/solicitacaoedittab.js') }}"></script>

<!-- Script para exibir mapa -->
<script type="text/javascript" src="{{ URL::asset('js/confirmeroute.js') }}"></script>

@stop