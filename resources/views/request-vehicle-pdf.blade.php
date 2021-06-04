<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/pdfreq.css') }}">
</head>

<body id="corpo-principal">

    <div id="principal">

        @foreach ($solicitacao as $solicitacao)
            <!--CABEÇALHO-->

            <div id="header">
                <!--IMAGENS-->
                <div class="logo">
                    <div class="col-md-12">
                        <img class="imgLogo" src="{{ asset('images/logo.png') }}" />
                        <img class="imgLogo" src="{{ asset('images/LogoHSJ.png') }}" />
                    </div>
                </div>

                <!--STATUS-->
                <div class="col-md-12" id="idStatus">
                    <p>
                        Nº: {{ $solicitacao->id }} <br>
                        <span>Status: <br></span>
                        <!--                        Alterar no bd AUTORIZADA PARA AUTORIZADO                        -->

                        @if ($solicitacao->statussolicitacao == 'AUTORIZADA')
                            <span style="color: green;"> {{ $solicitacao->statussolicitacao }}</span>
                        @elseif($solicitacao->statussolicitacao == 'PENDENTE')
                            <span style="color: red;"> {{ $solicitacao->statussolicitacao }}</span>
                        @elseif($solicitacao->statussolicitacao == 'REALIZADO')
                            <span style="color: aquamarine;"> {{ $solicitacao->statussolicitacao }}</span>
                        @elseif($solicitacao->statussolicitacao == 'NÃO REALIZADO')
                            <span style="color: blue;"> {{ $solicitacao->statussolicitacao }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <!--BODY-->
            <div class="corpo table-responsive text-center">
                <br>
                <h2 id="title">SISTEMA DE GESTÃO DE FROTA</h2>

                <table class="table">

                    <tbody class="col-md-12" style="border: solid 1px rgb(0, 0, 0);">
                        <tr>
                            <th style="border: solid 1px rgb(0, 0, 0);" scope="col" COLSPAN="5" ROWSPAN="5">SOLICITAÇÃO
                                DE
                                VEÍCULOS OFICIAIS</th>
                        </tr>
                    </tbody>

                    <tbody class="col-md-12" style="border: solid 1px rgb(0, 0, 0);">
                        <tr>
                            <th style="width:50%;">Setor solicitante</th>
                            <th style="width: 282px;">Nome do solicitante</th>
                        </tr>

                    <tbody class="col-md-12" style="border: solid 1px rgb(0, 0, 0);">
                        <tr>
                            @inject('sectors', '\App\Sector')
                            @foreach ($sectors->getSectors() as $sector)
                                @if ($solicitacao->setorsolicitante === $sector->cc)
                                    <td style="text-align:center;">&nbsp; {{ $sector->sector }}</td>
                                    <td style="text-align: center;">&nbsp;
                                        @inject('users', '\App\User')
                                        @foreach ($users->getUsers() as $user)
                                            @if ($user->id == $solicitacao->solicitante)
                                                {{ $user->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    </tbody>


                    <table class="table">

                        <tbody style="border: solid 1px rgb(0, 0, 0);">
                            <tr>
                                <th style="width: 650px;">Roteiro</th>
                                <th style="width: 650px;">Saída</th>
                            </tr>
                            <tr>

                                <td rowspan="3" style="text-align:center;">
                                    <b>ORIGEM: </b> &nbsp;{{ $solicitacao->origem }}<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <b>DESTINO: </b> {{ $solicitacao->destino }}
                                </td>
                                <td rowspan="3e" style="text-align:center;">
                                    <b>Data: </b>{{ date('d/m/Y', strtotime($solicitacao->datasaida)) }}<br>
                                    <b>Hora: </b>{{ date('H:i', strtotime($solicitacao->horasaida)) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table">
                        <tbody style="border: solid 1px rgb(0, 0, 0);">
                            <th style="width: 682px;">FINALIDADE</th>
                        </tbody>



                        <tbody style="border: solid 1px rgb(0, 0, 0);">
                            <tr>
                                <td colspan="6" style="width: 682px; text-align:center;"> &nbsp;
                                    ( @if ($solicitacao->unidade === null) &nbsp;
                                    @else
                                        <b>x</b>
                                    @endif )Transporte de paciente&nbsp;&nbsp;
                                    ( @if ($solicitacao->materiaisfin === null)
                                        &nbsp;
                                    @else <b>x</b> @endif )Transporte de materiais&nbsp;&nbsp;
                                    ( @if ($solicitacao->admfin === null) &nbsp;
                                    @else
                                        <b>x</b>
                                    @endif )Necessidades administrativas&nbsp;&nbsp;
                                </td>
                            </tr>
                        </tbody>


                        @if ($solicitacao->unidade !== null)


                            <tbody style="border: solid 1px rgb(0, 0, 0);">
                                <tr>
                                    <td style="border: solid 1px rgb(0, 0, 0);">

                                        <ul style="list-style: none;">

                                            <li>
                                                &nbsp;( @if ($solicitacao->sltmotivo != 'Alta')
                                                &nbsp; @else <b>x</b>
                                                @endif)
                                                Alta
                                            </li>

                                            <li>
                                                &nbsp;( @if ($solicitacao->sltmotivo != 'Transferência')
                                                &nbsp; @else <b>x</b>
                                                @endif )
                                                Transferência
                                            </li>

                                            <li>
                                                &nbsp;( @if ($solicitacao->sltmotivo != 'Remoção')
                                                &nbsp; @else <b>x</b>
                                                @endif )
                                                Remoção
                                            </li>

                                            <li>
                                                &nbsp;( @if ($solicitacao->sltmotivo != 'Exame com retorno')
                                                &nbsp; @else <b>x</b>
                                                @endif )
                                                Exame com retorno
                                            </li>

                                            <li>
                                                &nbsp;( @if ($solicitacao->sltmotivo != 'Exame sem retorno')
                                                &nbsp; @else <b>x</b>
                                                @endif )
                                                Exame sem retorno
                                            </li>

                                            <li>
                                                &nbsp;( @if ($solicitacao->sltmotivo != 'Outro')
                                                &nbsp; @else <b>x</b>
                                                @endif )
                                                Outro
                                            </li>

                                        </ul>
                                    </td>

                                    <td style="width: 437px; text-align:left;">
                                        {{ $solicitacao->estadopaciente }}
                                    </td>
                                </tr>

                            </tbody>

                        @else
                            <tbody style="border: solid 1px rgb(0, 0, 0);">
                                <tr>
                                    @if ($solicitacao->materiaisfin !== null && $solicitacao->admfin === null)
                                        <td style="border: solid 1px rgb(0, 0, 0);">
                                            &nbsp;<b>DESCRIÇÃO: </b>
                                            {{ $solicitacao->materiaisfin }}
                                        </td>
                                    @elseif($solicitacao->materiaisfin === null && $solicitacao->admfin !== null)
                                        <td style="border: solid 1px rgb(0, 0, 0);">
                                            &nbsp;<b>DESCRIÇÃO: </b>
                                            {{ $solicitacao->admfin }}
                                        </td>
                                    @endif
                                </tr>
                            </tbody>
                    </table>
        @endif

        <!-- -----------  -->

        @if ($solicitacao->statussolicitacao != 'PENDENTE')

            <table class="table">
                <tbody style="border: solid 1px rgb(0, 0, 0);">
                    <th scope="col" COLSPAN="2" ROWSPAN="1" id="roadMapTh">SOLICITAÇÃO DE VEÍCULOS OFICIAIS
                    </th>
                </tbody>

                <tbody>
                    <tr>
                        <th style="width: 337px;">Veículo</th>
                        <th style="width: 337px;">Motorista</th>
                    </tr>
                    <tr>
                        @inject('vehicles', '\App\Vehicle')
                        @foreach ($vehicles->getVehicles() as $vehicle)
                            @if ($authorization[0]->vehicle == $vehicle->id)
                                <td>{{ $vehicle->brand }} | {{ $vehicle->model }} |
                                    {{ $vehicle->placa }}</td>
                            @endif
                        @endforeach

                        @inject('drivers', '\App\Driver')
                        @foreach ($drivers->getDrivers() as $driver)
                            @if ($driver->id == $authorization[0]->driver)
                                <td>{{ $driver->name_driver }}</td>
                            @endif
                        @endforeach

                    </tr>
                </tbody>
            </table>

            <table class="table">
                <tbody style="border: solid 1px rgb(0, 0, 0);">
                    <tr>
                        <th style="width: 633px;" colspan="5">UTILIZAÇÃO DO VEÍCULO</th>
                    </tr>
                <tbody style="border: solid 1px rgb(0, 0, 0);">
                    <tr>
                        <td><b>Data Saída</b></td>
                        <td><b>Hora Saída</b></td>
                        <td><b>Data Retorno</b></td>
                        <td><b>Hora Retorno</b></td>
                        <td style="width: 169px;"><b>Km's Rodados</b></td>

                    </tr>
                    <tr>
                        <td>{{ $authorization[0]->authorized_departure_date }}</td>
                        <td>{{ $authorization[0]->authorized_departure_time }}</td>
                        <td>{{ $authorization[0]->return_date }}</td>
                        <td>{{ $authorization[0]->return_time }}</td>

                        <td>{{ $solicitacao->mileage_traveled }}</td>
                    </tr>
                </tbody>
            </table>


            <table class="table">
                <tbody style="border: solid 1px rgb(0, 0, 0);">
                    <th style="width: 633px;" colspan="4">ÁREA LOGÍSTA DOS TRANSPORTES</th>
                </tbody>
                <tbody>
                    <tr>
                        <th style="width: 209px;">Autorizado por</th>
                        <th style="width: 100px;">Data</th>
                        <th style="width: 249px;">Assinatura do Motorista</th>
                        <th style="width: 100px;">Data</th>
                    </tr>
                    <tr>
                        <td>{{ $authorization[0]->authorizer }}</td>
                        <td>
                            <?php
                            $my_datetime = $authorization[0]->updated_at;
                            echo date('Y-m-d H:i:s', strtotime("$my_datetime UTC"));
                            ?>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

        @endif

        <div id="footer">
        </div>
    </div>
</body>
@endforeach
</div>
</body>

</html>
