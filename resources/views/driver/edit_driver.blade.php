@extends('layouts.application')

@section('content')
<h1 class="ls-title-intro ls-ico-user-add">Editar dados de motorista</h1>
<div class="ls-box">

    <h5 class="ls-title-5">Solicitação de uso de veiculos oficiais:</h5>
    <hr>
    <form method="POST" action="{{route('driver.edit',$driver->id)}}" class="ls-form row">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

        <fieldset>
            <div class="col-md-12">
                <div class="form-group col-md-3">
                    <label class="ls-label col-md-12">
                        <b class="ls-label-text">Nome do motorista</b>
                        <input type="text" class="form-control" name="name_driver" value="{{$driver->name_driver}}">

                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label class="ls-label col-md-12">
                        <b class="ls-label-text">CPF</b>
                        <input type="text" name="cpf" class="ls-mask-cpf" placeholder="000.000.000-00" value="{{$driver->cpf}}">

                    </label>
                </div>

            </div>
            <div class="col-md-12">
                <div class="form-group col-md-3">
                    <div class="ls-label">
                        <p>Marque as categorias em que o motorista é habilitado:</p>
                        
                        <?php $tags =  $driver->hab;
                        $tagsArray = explode(',', $tags); ?>
                        <label class="ls-label-text">
                            @if(in_array("A", $tagsArray))
                            <input type="checkbox" name="hab[]" checked value="A">
                            @else
                            <input type="checkbox" name="hab[]" value="A">
                            @endif
                            A
                        </label>
                        <label class="ls-label-text">
                            @if(in_array("B", $tagsArray))
                            <input type="checkbox" name="hab[]" checked value="B">
                            @else
                            <input type="checkbox" name="hab[]" value="B">
                            @endif
                            B
                        </label>
                        <label class="ls-label-text">
                            @if(in_array("C", $tagsArray))
                            <input type="checkbox" name="hab[]" checked value="C">
                            @else
                            <input type="checkbox" name="hab[]" value="C">
                            @endif
                            C
                        </label>
                        <label class="ls-label-text">
                            @if(in_array("D", $tagsArray))
                            <input type="checkbox" name="hab[]" checked value="D">
                            @else
                            <input type="checkbox" name="hab[]" value="D">
                            @endif
                            D
                        </label>
                        <label class="ls-label-text">
                            @if(in_array("E", $tagsArray))
                            <input type="checkbox" name="hab[]" checked value="E">
                            @else
                            <input type="checkbox" name="hab[]" value="E">
                            @endif
                            E
                        </label>
                    </div>
                </div>

            </div>

        </fieldset>
        <div class="ls-actions-btn">
            <input type="submit" value="Atualizar" class="ls-btn-dark" title="update" style="font-weight: bold; background-color: blue;">
            <a href="{{ route('solicitacoes') }}" class="ls-btn-primary-danger" style="font-weight: bold;">Cancelar</a>
        </div>
    </form>
</div>

@stop