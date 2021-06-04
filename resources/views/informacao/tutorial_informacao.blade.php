@extends('layouts.application')

@section('content')
    <fieldset>
        <h1 class="ls-title-intro ls-ico-question">Tutorial sobre o Sistema</h1>

        <br>

        <h3 class="ls-title-3">WEBCAR 2ª VERSÃO</h3>

        <br><br>

        <table class="table table-hover">
            <tbody>
                <tr>

                    <th scope="row">
                        <a href="{{route('cad.blade.php')}}" class="ls-title-3">Cadastro</a>
                    </th>

                    <th scope="row">
                        <a href="access.blade.php" class="ls-title-3">Primeiro Acesso</a>
                    </th>

                    <th scope="row">
                        <a href="vehiclerequest.blade.php" class="ls-title-3">Solicitar Veículo</a>
                    </th>

                    <th scope="row">
                        <a href="verifyrequest.blade.php" class="ls-title-3">Verificar Solicitação</a>
                    </th>

                    <th scope="row">
                        <a href="resetpassword.blade.php" class="ls-title-3">Resetar Senha</a>
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
