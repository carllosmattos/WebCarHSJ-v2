@extends('layouts.application')

@section('content')
<h1 class="ls-title-intro ls-ico-user-add">Cadastrar motorista</h1>
<div class="ls-box">

  <h5 class="ls-title-5">Cadastre um motorista</h5>
  <hr>

  <form method="POST" action="{{ route('driver.postAdd') }}" class="ls-form row" id="add" data-ls-module="form">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

    <fieldset>
      <div class="col-md-12">
        <div class="form-group col-md-3">
          <label class="ls-label col-md-12">
            <b class="ls-label-text">Nome do motorista</b>
            <input type="text" class="form-control" name="name_driver" value="{{old('name_driver')}}" required>

          </label>
        </div>

        <div class="form-group col-md-3">
          <label class="ls-label col-md-12">
            <b class="ls-label-text">CPF</b>
            <input type="text" name="cpf" class="ls-mask-cpf" placeholder="000.000.000-00" required>

          </label>
        </div>

      </div>
      <div class="col-md-12">
        <div class="form-group col-md-3">
          <div class="ls-label">
            <p>Marque as categorias em que o motorista é habilitado:</p>
            <div class="col-md-10">
              <div class="col-md-2">
                <label class="ls-label-text">
                  <input type="checkbox" name="hab[]" value="A">
                  A
                </label>
              </div>
              <div class="col-md-2">
                <label class="ls-label-text">
                  <input type="checkbox" name="hab[]" value="B">
                  B
                </label>
              </div>
              <div class="col-md-2">
                <label class="ls-label-text">
                  <input type="checkbox" name="hab[]" value="C">
                  C
                </label>
              </div>
              <div class="col-md-2">
                <label class="ls-label-text">
                  <input type="checkbox" name="hab[]" value="D">
                  D
                </label></div>
              <div class="col-md-2">
                <label class="ls-label-text">
                  <input type="checkbox" name="hab[]" value="E">
                  E
                </label></div>
            </div>
          </div>
        </div>

      </div>

    </fieldset>
    <div class="ls-actions-btn">
      <input type="submit" value="Cadastrar" class="ls-btn-primary" title="Cadastrar" style="font-weight: bold;">
      <input class="ls-btn-primary-danger" type="reset" value="Limpar" style="font-weight: bold;">
    </div>
  </form>
</div>

@stop