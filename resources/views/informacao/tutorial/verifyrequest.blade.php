@extends('layouts.application')

@section('content')
    <fieldset>
        <h1 class="ls-title-intro ls-ico-question">Tutorial sobre o Sistema</h1>

        <br>
        <h3 class="ls-title-3">WEBCAR 2ª VERSÃO</h3>

        <br><br>
        <!-- VERIFICAR SOLICITAÇÃO -->
        <h5 class="ls-title-3">Verificar Solicitação:</h5>

        <br>

        <p style="font-size: 16px;">

            Ao acessar a <b><a href="/" style="color: black;">Pagina Inicial</a></b> é possivel ver as
            solicitações pendentes.<br>
            Mas, ao acessar <b>Solicitações -> <a href="{{ route('solicitacoes') }}" style="color: black;">
                    Verificar Solicitações</a></b>, é possivel listar todas,
            tanto pendentes, quanto realizadas.
        </p><br>
        <img src="{{ URL::asset('gifs/verify.gif') }}" />

        <!-- /VERIFICAR SOLICITAÇÃO -->
