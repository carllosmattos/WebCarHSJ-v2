@extends('layouts.application')

@section('content')

<h1 class="ls-title-intro ls-ico-dashboard">Adicionar Veiculo</h1>
<div class="ls-box">
  <hr>
  <h5 class="ls-title-5">Cadastrar Veículo:</h5>
  <form method="POST" action="{{ route('vehicle.postAdd') }}" class="ls-form row">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <fieldset>

      <div class="col-md-12">
        <div class="form-group col-md-4">
          <label class="ls-label col-md-12 @error('brand') ls-error @enderror">
            <b class="ls-label-text">Marca:</b>
            <input type="text" maxlength="20" name="brand" value="{{old('brand')}}">

            @error('brand')
            <div class="ls-help-message">
              {{$message}}
            </div>
            @enderror

          </label>
        </div>
        <div class="form-group col-md-4">
          <label class="ls-label col-md-12 @error('model') ls-error @enderror">
            <b class="ls-label-text">Modelo:</b>
            <input class="ls-no-spin" type="text" name="model" value="{{old('model')}}">

            @error('model')
            <div class="ls-help-message">
              {{$message}}
            </div>
            @enderror

          </label>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group col-md-4">
          <label class="ls-label col-md-12 @error('placa') ls-error @enderror">
            <b class="ls-label-text">Placa:</b>
            <input type="text" name="placa" class="ls-no-spin form-control" value="{{old('placa')}}">

            @error('placa')
            <div class="ls-help-message">
              {{$message}}
            </div>
            @enderror

          </label>
        </div>
        <div class="form-group col-md-4">
          <label class="ls-label col-md-12 @error('year') ls-error @enderror">
            <b class="ls-label-text">Ano:</b>
            <input class="ls-mask-date" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="year" value="{{old('year')}}" maxlength="4" autocomplete="off">

            @error('year')
            <div class="ls-help-message">
              {{$message}}
            </div>
            @enderror

          </label>
        </div>
      </div>

      <div class="col-md-12">
        <div class="form-group col-md-4">
          <label class="ls-label col-md-12 @error('situacao') ls-error @enderror">
            <script type="text/javascript" src="<?php echo asset('../js/changeinp.js') ?>"></script>
            <b class="ls-label-text">Situação</b>
            <div class="ls-custom-select">
              <select id="sit" name="situacao" class="ls-select" onchange="verifica(this.value)">
                <option value=""></option>
                <option style="background-color: green; color: #fff; font-weight: bold;" value="LIVRE">LIVRE</option>
                <option style="background-color: blue; color: #fff; font-weight: bold;" value="EM USO">EM USO</option>
                <option style="background-color: red; color: #fff; font-weight: bold;" value="MANUTENÇÃO">MANUTENÇÃO</option>
              </select>
            </div>

            @error('situacao')
            <div class="ls-help-message">
              {{$message}}
            </div>
            @enderror

          </label>
        </div>

        <div class="form-group col-md-2">
          <label class="ls-label col-md-12 @error('kilometers_per_liter') ls-error @enderror">
            <b class="ls-label-text">Consumo médio(KM/L)</b>
            <input class="ls-mask-date" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="kilometers_per_liter" value="{{old('kilometers_per_liter')}}" autocomplete="off">

            @error('kilometers_per_liter')
            <div class="ls-help-message">
              {{$message}}
            </div>
            @enderror

          </label>
        </div>

        <div class="form-group col-md-2">
          <label class="ls-label col-md-12 @error('last_price') ls-error @enderror">
            <b class="ls-label-text">Último preço do combustivel</b>
            <input class="ls-mask-date" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="last_price" value="{{old('last_price')}}" autocomplete="off">

            @error('last_price')
            <div class="ls-help-message">
              {{$message}}
            </div>
            @enderror

          </label>
        </div>

      </div>

      <div class="col-md-12">
        <div class="form-group col-md-4">
          <label class="ls-label col-md-12 @error('situacao') ls-error @enderror">
            <b class="ls-label-text">Motorista</b>
            <div class="ls-custom-select">
              <select name="driver_id" class="ls-select">
                @foreach($drivers as $driver)
                <option value="{{$driver->id}}">{{$driver->name_driver}}</option>
                @endforeach
              </select>
            </div>

            @error('situacao')
            <div class="ls-help-message">
              {{$message}}
            </div>
            @enderror

          </label>
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