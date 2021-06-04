<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/pdfauth.css') }}">
</head>

<body id="corpo-principal">

    <div id="principal">

        @foreach ($authorizacao as $authorizacao)
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
                        Nº: {{ $authorizacao->id }}<br>
                        <span>Status: <br></span>
                        @if ($authorizacao->statusauthorization == 'AUTORIZADO')
                            <span style="color: green;"> {{ $authorizacao->statusauthorization }}</span>
                        @elseif($authorizacao->statusauthorization == 'PENDENTE')
                            <span style="color: red;"> {{ $authorizacao->statusauthorization }}</span>
                        @elseif($authorizacao->statusauthorization == 'REALIZADO')
                            <span style="color: aquamarine;"> {{ $authorizacao->statusauthorization }}</span>
                        @elseif($authorizacao->statusauthorization == 'NÃO REALIZADO')
                            <span style="color: blue;"> {{ $authorizacao->statusauthorization }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <!--BODY-->
            <div class="corpo table-responsive text-center">
                <br>
                <h2 id="title">SISTEMA DE GESTÃO DE FROTA</h2>

                <table class="table">

                    <tbody class="col-md-12">
                        <tr>
                            <th style="border: solid 1px rgb(0, 0, 0);" scope="col" COLSPAN="5" ROWSPAN="5">AUTORIZAÇÃO
                                DE
                                SAÍDAS</th>
                        </tr>
                    </tbody>

                    <tbody style="border: solid 1px rgb(0, 0, 0);">
                        <tr>
                            <th scope="col" COLSPAN="5" ROWSPAN="5" id="roadMapTh">ROTEIRO</th>
                        </tr>
                    </tbody>

                    <tbody style="border: solid 1px rgb(0, 0, 0);">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Setor Solicitante</th>
                            <th scope="col">Origem</th>
                            <th scope="col">Destino</th>
                            <th scope="col">Quilometros Percorridos</th>
                        </tr>
                    </tbody>

                    <tbody style="border: solid 1px rgb(0, 0, 0);">
                        @foreach ($solicitacoes as $solicitacao)
                            <tr>
                                <td id="tdForm">{{ $solicitacao->id }}</td>

                                @inject('sectors', '\App\Sector')

                                @foreach ($sectors->getSectors() as $sector)
                                    @if ($solicitacao->setorsolicitante === $sector->cc)

                                        <td id="tdForm">{{ $sector->cc }} - {{ $sector->sector }}</td>

                                    @endif

                                @endforeach

                                <td id="tdForm">{{ $solicitacao->origem }}</td>
                                <td id="tdForm">{{ $solicitacao->destino }}</td>
                                <td id="tdForm">{{ number_format($solicitacao->mileage_traveled, 0) }}</td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>


                <table class="table">
                    <tbody>
                        <tr>
                            <th style="width: 337px; border: solid 1px #000" colspan="2">Saída</th>
                            <th style="width: 337px; border: solid 1px #000" colspan="2">Retorno</th>
                        </tr>
                        <tr>
                            <td>Data</td>
                            <td>Hora</td>
                            <td>Data</td>
                            <td>Hora</td>
                        </tr>
                        <tr>
                            <td>{{ $authorizacao->authorized_departure_date }}</td>
                            <td>{{ $authorizacao->authorized_departure_time }}</td>
                            <td>{{ $authorizacao->return_date }}</td>
                            <td>{{ $authorizacao->return_time }}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table">
                    <tbody>

                        <tr>
                            <th style="width: 233px; border: solid 1px #000">Veículo</th>
                            <th style="width: 233px; border: solid 1px #000">Motorista</th>
                            <th style="width: 200px; border: solid 1px #000">Total percorrido(Km)</th>
                        </tr>

                        <tr>
                            @inject('vehicles', '\App\Vehicle')
                            @foreach ($vehicles->getVehicles() as $vehicle)
                                @if ($authorizacao->vehicle == $vehicle->id)

                                    <td>{{ $vehicle->brand }} | {{ $vehicle->model }} | {{ $vehicle->placa }}
                                    </td>

                                @endif
                            @endforeach

                            @inject('drivers', '\App\Driver')
                            @foreach ($drivers->getDrivers() as $driver)
                                @if ($driver->id == $authorizacao->driver)

                                    <td>{{ $driver->name_driver }}</td>

                                @endif
                            @endforeach

                            <td>
                                <?php
                                $total = $authorizacao->return_mileage - $authorizacao->output_mileage;
                                echo $total;
                                ?>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <table class="table">
                    <tbody>
                        <tr>
                            <th style="width: 337px; border: solid 1px #000">Autorizado por</th>
                            <th style="width: 337px; border: solid 1px #000">Data</th>
                        </tr>
                        <tr>
                            <td>{{ $authorizacao->authorizer }}</td>
                            <td>
                                <?php
                                $my_datetime = $authorizacao->updated_at;
                                echo date('Y-m-d H:i:s', strtotime("$my_datetime UTC"));
                                ?>
                            </td>
                        </tr>
                    </tbody>

                </table>

        @endforeach
    </div>
</body>

</html>
