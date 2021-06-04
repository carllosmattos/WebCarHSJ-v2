@extends('layouts.application')

@section('content')

<h1 class="ls-title-intro ls-ico-cog">Gerenciar papeis de usuário</h1>
<div class="ls-box">
  <hr>
  <h5 class="ls-title-5">Editar custo:</h5>
  <form method="POST" action="{{route('roleuser.edit',$role_user->id)}}" class="ls-form row">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

    <fieldset>

    <div class="col-md-12">
        <div class="form-group col-md-4">
          <label class="ls-label col-md-12">
            <b class="ls-label-text">Usuário</b>
            <div class="ls-custom-select">
              <select name="user_id" class="ls-select">
                @foreach($users as $user)
                @if(($user->id) == ($role_user->user_id))
                  <option value="{{$user->id}}">{{$user->name}}</option>
                @endif
                @endforeach
              </select>
            </div>
          </label>
        </div>
        <div class="form-group col-md-4">
          <label class="ls-label col-md-12">
            <b class="ls-label-text">Papel</b>
            <div class="ls-custom-select">
              <select name="role_id" class="ls-select"> 
                @foreach($roles as $role)
                <!-- Editar -->
                  @if(($role->id) == ($role_user->role_id))
                    <option value="{{$role->id}}" selected="selected">{{$role->name}}</option>
                  @endif
                  
                  @if(($role->id) != ($role_user->role_id))
                    <option value="{{$role->id}}">{{$role->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </label>
        </div>
        <div class="form-group col-md-4">
          <b class="ls-label-text">Papel</b>
          <p><strong>SUPER ADM</strong> Infraestrutura, administrador geral. Nível 1.</p>
          <p><strong>ADM</strong> Serviços Gerais, administrador de frota. Nível 2.</p>
          <p><strong>MANAGER</strong> Gestores Administrativos, ADM Financeiro, ADM Custos, etc. Nível 3.</p>
          <p><strong>PAD</strong>Programa de atendimento Domiciliar</p>
          <p><strong>USER REQUEST</strong> Gestores de setor ou responsáveis autorizados, responsáveis por solicitar frota. Nível 4</p>
          <p><strong>NO ROLE</strong> Usuário sem permissões</p>
        </div>
      </div>

    </fieldset>

    <div class="ls-actions-btn">
      <input type="submit" value="Atualizar" class="ls-btn-dark" title="update" style="font-weight: bold; background-color: blue;">
      <a href="{{ route('roleusers') }}" class="ls-btn-primary-danger" style="font-weight: bold;">Cancelar</a>
    </div>
  </form>
</div>


@stop