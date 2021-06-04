@extends('layouts.application')

@section('content')
<h1 class="ls-title-intro ls-ico-user-add">Listagem de motoristas</h1>
<div class="table-responsive">
  <div class="ls-box ">
    <div class="box-header">

    </div>

    <table class="ls-table ls-table-striped ls-bg-header ">
      <thead>
        <tr>
          <th>Nome do motorista</th>
          <th>CPF</th>
          <th>Cat. Habilitação</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($drivers as $driver)
        <tr>
          @if($driver->name_driver != "SEM MOTORISTA")
            <td>{{ $driver->name_driver }}</td>
          @endif
          <td>{{ $driver->cpf }}</td>
          <td>{{ $driver->hab }}</td>
          <td>
            @if($driver->name_driver != "SEM MOTORISTA")
            <div class="col-12">
              <div class="col-md-4">
                <a class="ls-ico-pencil ls-btn-dark" style="background-color: blue;" href="{{ route('driver.edit', $driver->id) }}"></a>
              </div>
              <div class="col-md-4">
                <a class="ls-ico-remove ls-btn-primary-danger" href="{{ route('driver.delete', $driver->id) }}"></a>
              </div>
            </div>
            @endif

          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>
@stop