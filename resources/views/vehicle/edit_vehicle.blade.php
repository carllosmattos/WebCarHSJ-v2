@extends('layouts.application')

@section('content')

<h1 class="ls-title-intro ls-ico-dashboard">Adicionar Veiculo</h1>
<div class="ls-box">
  <hr>
  <h5 class="ls-title-5">Cadastrar Veículo:</h5>
  <form method="POST" action="{{route('vehicle.edit',$vehicle->id)}}" class="ls-form row">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <fieldset>

      <div class="col-md-12">
        <div class="form-group col-md-4">
          <label class="ls-label col-md-12 @error('brand') ls-error @enderror">
            <b class="ls-label-text">Marca:</b>
            <input value="{{ $vehicle->brand }}" type="text" name="brand" placeholder="Marca do Veiculo">

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
            <input value="{{ $vehicle->model }}" type="text" name="model" placeholder="Modelo">

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
            <input value="{{ $vehicle->placa }}" type="text" name="placa" placeholder="Placa">

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
            <input value="{{ $vehicle->year }}" class="ls-mask-date" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="year" placeholder="Ano" maxlength="4" autocomplete="off">

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
            <script type="text/javascript" src="<?php echo asset('../js/changeinpedit.js') ?>"></script>
            <b class="ls-label-text">Situação</b>
            <div class="ls-custom-select">
              <select id="editsit" name="situacao" class="ls-select" onchange="verifica(this.value)">
                <option value="{{ $vehicle->situacao }}">{{ $vehicle->situacao }}</option>
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
            <input class="ls-mask-date" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="kilometers_per_liter" value="{{$vehicle->kilometers_per_liter}}" autocomplete="off">

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
            <input class="ls-mask-date" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="last_price" value="{{$vehicle->last_price}}" autocomplete="off">

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
                @if($vehicle->driver_id == $driver->id)
                <option value="{{$vehicle->driver_id}}" selected>{{$driver->name_driver}}</option>
                @else
                @endif

                @if($vehicle->driver_id != $driver->id)
                <option value="{{$driver->id}}">{{$driver->name_driver}}</option>
                @else
                @endif

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
      <input type="submit" value="Atualizar" class="ls-btn-dark" title="update" style="font-weight: bold; background-color: blue;">
      <a href="{{ route('vehicles') }}" class="ls-btn-primary-danger" style="font-weight: bold;">Cancelar</a>
    </div>
  </form>
</div>


@stop