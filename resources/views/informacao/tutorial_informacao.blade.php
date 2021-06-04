@extends('layouts.application')

@section('content')
    <fieldset>

        <h1 class="ls-title-intro ls-ico-question">Tutorial sobre o Sistema</h1>

        <br>

        <h3 class="ls-title-3">WEBCAR 2ª VERSÃO</h3>

        <br><br>

        <table class="table">
            <tbody>
                <tr>

                    <style>
                        #thTutorial {
                            text-align: center;
                            border: none;
                            padding: 16px 32px;
                            text-align: center;
                            font-size: 16px;
                            margin: 4px 2px;
                            border-radius: 4px;
                            transition: 0.4s;
                        }

                        #thTutorial:hover {
                            background-color: #1ab551;
                            color: #fff;
                        }

                        a:hover {
                            color: #fff;
                            text-decoration: none;
                        }

                    </style>

                    <th scope="row" id="thTutorial">
                        <a href="/informacao/cad" class="ls-title-3">Cadastro</a>
                    </th>

                    <th scope="row" id="thTutorial">
                        <a href="/informacao/access" class="ls-title-3">Primeiro Acesso</a>
                    </th>

                    <th scope="row" id="thTutorial">
                        <a href="/informacao/vehiclerequest" class="ls-title-3">Solicitar Veículo</a>
                    </th>

                    <th scope="row" id="thTutorial">
                        <a href="/informacao/verifyrequest" class="ls-title-3">Verificar Solicitação</a>
                    </th>

                    <th scope="row" id="thTutorial">
                        <a href="/informacao/resetpassword" class="ls-title-3">Resetar Senha</a>
                    </th>
                </tr>
        </table>

    </fieldset>

    <br><br><br><br>

    <h1>CONTINUA EM BREVE...</h1>

    <br><br>

    <footer class="footer">© 2020 - Todos os direitos reservados</footer>

    <br>
@stop
