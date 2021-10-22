@extends('layouts.app')

@section('title_tab', 'Usuario')

@section('extra_css')
@endsection

@section('breadcrumb')
    <i class="fa fa-user"></i> Detalle de usuario
@endsection

@section('content')

<div ng-controller="UserDetailController" ng-init="user = {{ json_encode($user) }}; centers = {{ json_encode($selects['centers']) }}; roles = {{ json_encode($selects['roles']) }};">
    <div class="row">
        {{ get_alert() }}

        @if($errors->any())
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert"></button>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="blog">
                <div class="blog-header">
                    <h5 class="blog-title">Detalle de Usuario</h5>
                </div>
                <div class="blog-body">
                    {{-- @if($user->status === 'deleted')
                        <div class="alert alert-warning">
                            <strong>ELIMINADO</strong> Este usuario ha sido eliminado.
                        </div>
                    @endif --}}
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-info" ng-click="editDetails()">
                                <i class="fa fa-pencil"></i>
                                Editar
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-info table-striped">
                                <tr>
                                    <th>Nombre Usuario</th>
                                    <td>{{ $user->name }}</td>
                                    <th>Seoname</th>
                                    <td>{{ $user->seoname }}</td>
                                </tr>
                                <tr>
                                    <th>Email de Usuario</th>
                                    <td>{{ $user->email }}</td>
                                    <th>Rol del Usuario</th>
                                    <td>{{ $user->role->name }}</td>
                                </tr>
                                <tr>
                                    <th>Lugar de Trabajo</th>
                                    <td>{{ $user->center->name }}</td>
                                    <th>Status</th>
                                    <td>{{ $user->status }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('user::user.partials.edit_details')

</div>

@endsection

@section('extra_scripts')
    @include('layouts.angular', ['controller' => 'user']);
@endsection
