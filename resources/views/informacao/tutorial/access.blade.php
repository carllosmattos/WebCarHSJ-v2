@extends('layouts.application')

@section('content')
    <fieldset>
        <h1 class="ls-title-intro ls-ico-question">Tutorial sobre o Sistema</h1>

        <br>
        <h3 class="ls-title-3">WEBCAR 2ª VERSÃO</h3>

        <br><br>
        <!-- PRIMEIRO ACESSO -->
        <h5 class="ls-title-3">Primeiro Acesso:</h5>

        <br>

        <p style="font-size: 16px;">
            Ao criar o cadastro, <b>SOLICITE O ADMINISTRADOR</b> para que ele libero o acesso ao seu usuário.
        </p><br>
        <img src="{{ URL::asset('gifs/accessdenied.gif') }}" />

        <br><br><br>

        <p style="font-size: 16px;">
            Algumas informações sobre o WebCar se encontram na aba <b>SOBRE</b>, visite-a.
        </p><br>
        <img src="{{ URL::asset('gifs/inform.gif') }}" />
        <!-- /PRIMEIRO ACESSO -->
