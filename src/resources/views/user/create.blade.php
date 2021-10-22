@extends('layouts.app')

@section('title_tab', 'User')

@section('extra_css')
@endsection

@section('breadcrumb')
    @if(isset($user))
        <i class="fa fa-user"></i> Editar Usuario
    @else
        <i class="fa fa-user"></i> Nuevo Usuario
    @endif
@endsection

@section('content')

<form action="/user/store" method="POST" novalidate="novalidate" class="form-horizontal bv-form">
    {{ csrf_field() }}

    @if($errors->any())
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert"></button>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="blog">
                <div class="blog-header">
                    <h5 class="blog-title">Datos Generales</h5>
                </div>
                <div class="blog-body">
                    <legend>
                        Recuerda que la toma de datos generales debe ser breve. Todos los campos marcados con (*) son obligatorios.
                    </legend>

                    <div class="form-group col-xs-12 col-sm-12 col-md-12 mb3">
                        <div class="col-xs-12 col-sm-12 col-md-2"></div>
                        <div class="col-xs-12 col-sm-12 col-md-6"><img src="/img/icons/n1.png" alt="" class="mt2n">&nbsp;&nbsp;<strong>Nombre completo del usuario:</strong></div>
                    </div>

                    <div class="form-group has-feedback">
                        <div class="row">
                            <label class="col-xs-12 col-sm-12 col-md-2 control-label">Nombre*:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                @if(isset($user))
                                    <input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $user->name }}"><i class="form-control-feedback" style="display: none;"></i>
                                @else
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"><i class="form-control-feedback" style="display: none;"></i>
                                @endif
                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="name" data-bv-result="NOT_VALIDATED" style="display: none;">The title is required</small><small class="help-block" data-bv-validator="stringLength" data-bv-for="title" data-bv-result="NOT_VALIDATED" style="display: none;">The title must be less than 200 characters long</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group has-feedback">
                        <div class="row">
                            <label class="col-xs-12 col-sm-12 col-md-2 control-label">Apellidos*:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                @if(isset($user))
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ? old('last_name') : $user->last_name }}"><i class="form-control-feedback" data-bv-icon-for="last_name" style="display: none;"></i>
                                @else
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"><i class="form-control-feedback" data-bv-icon-for="last_name" style="display: none;"></i>
                                @endif
                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="last_name" data-bv-result="NOT_VALIDATED" style="display: none;">The title is required</small><small class="help-block" data-bv-validator="stringLength" data-bv-for="title" data-bv-result="NOT_VALIDATED" style="display: none;">The title must be less than 200 characters long</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-xs-12 col-sm-12 col-md-12 mb3">
                        <div class="col-xs-12 col-sm-12 col-md-2"></div>
                        <div class="col-xs-12 col-sm-12 col-md-6"><img src="/img/icons/n2.png" alt="" class="mt2n">&nbsp;&nbsp;<strong>*Asigne el centro de trabajo (Opcional):</strong></div>
                    </div>

                    <div class="form-group has-feedback">
                        <div class="row">
                            <label class="col-xs-12 col-sm-12 col-md-2 control-label">Empresa:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6 selectContainer">
                                <select name="center" id="center" class="form-control">
                                    <option value="">Selecciona una opción</option>

                                    @foreach($selects['centers'] as $center)
                                        @if(isset($user))
                                            <option value="{{ $center->id }}" {{ $center->id == $user->center->id ? 'selected' : '' }}> {{ $center->name }}</option>
                                        @else
                                            <option value="{{ $center->id }}"> {{ $center->name }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <i class="form-control-feedback" data-bv-icon-for="canalized_to" style="display: none;"></i>
                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="canalized_to" data-bv-result="NOT_VALIDATED" style="display: none;">The genre is required</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-xs-12 col-sm-12 col-md-12 mb3">
                        <div class="col-xs-12 col-sm-12 col-md-2"></div>
                        <div class="col-xs-12 col-sm-12 col-md-6"><img src="/img/icons/n3.png" alt="" class="mt2n">&nbsp;&nbsp;<strong>Asignar el rol que ejercera el usuario:</strong></div>
                    </div>

                    <div class="form-group has-feedback">
                        <div class="row">
                            <label class="col-xs-12 col-sm-12 col-md-2 control-label">Tipo de rol:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6 selectContainer">
                                <select name="role" id="role" class="form-control">
                                    <option value="0">Selecciona una opción</option>

                                    @foreach($selects['roles'] as $role)
                                        <option value="{{ $role->id }}"> {{ $role->name }}</option>
                                    @endforeach
                                </select>

                                <i class="form-control-feedback" data-bv-icon-for="canalized_to" style="display: none;"></i>
                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="canalized_to" data-bv-result="NOT_VALIDATED" style="display: none;">The genre is required</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-xs-12 col-sm-12 col-md-12 mb3">
                        <div class="col-xs-12 col-sm-12 col-md-2"></div>
                        <div class="col-xs-12 col-sm-12 col-md-6"><img src="/img/icons/n4.png" alt="" class="mt2n">&nbsp;&nbsp;<strong>Solicitar al usuario un correo electrónico y contraseña:</strong></div>
                    </div>

                    <div class="form-group has-feedback">
                        <div class="row">
                            <label class="col-xs-12 col-sm-12 col-md-2 control-label">Correo:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                @if(isset($user))
                                    <input type="email" class="form-control" name="email" value="{{ old('email') ? old('email') : $user->email }}"><i class="form-control-feedback" style="display: none;"></i>
                                @else
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"><i class="form-control-feedback" style="display: none;"></i>
                                @endif
                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="email" data-bv-result="NOT_VALIDATED" style="display: none;">The title is required</small><small class="help-block" data-bv-validator="stringLength" data-bv-for="title" data-bv-result="NOT_VALIDATED" style="display: none;">The title must be less than 200 characters long</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group has-feedback">
                        <div class="row">
                            <label class="col-xs-12 col-sm-12 col-md-2 control-label">Contraseña:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">

                                <input type="password" class="form-control" name="password"><i class="form-control-feedback" style="display: none;"></i>
                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="email" data-bv-result="NOT_VALIDATED" style="display: none;">The title is required</small><small class="help-block" data-bv-validator="stringLength" data-bv-for="title" data-bv-result="NOT_VALIDATED" style="display: none;">The title must be less than 200 characters long</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group has-feedback">
                        <div class="row">
                            <label class="col-xs-12 col-sm-12 col-md-2 control-label">Repetir contraseña:</label>
                            <div class="col-xs-12 col-sm-12 col-md-6">

                                <input type="password" class="form-control" name="password_confirm"><i class="form-control-feedback" style="display: none;"></i>
                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="email" data-bv-result="NOT_VALIDATED" style="display: none;">The title is required</small><small class="help-block" data-bv-validator="stringLength" data-bv-for="title" data-bv-result="NOT_VALIDATED" style="display: none;">The title must be less than 200 characters long</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="blog">
                <button type="submit" class="btn btn-info">
                        {{ isset($user) ? 'Guardar' : 'Guardar'}}
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
