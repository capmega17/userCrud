@extends('layouts.app')

@section('title_tab', 'Usuarios')

@section('extra_css')
@endsection

@section('breadcrumb')
    <i class="fa fa-book"></i> Usuarios
@endsection

@section('content')

<div ng-controller="UserListController" ng-init="centers = {{ json_encode($selects['centers']) }}; roles = {{ json_encode($selects['roles']) }};">
    {{ get_alert() }}

    @if($errors->any())
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert"></button>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif


    <span>Busqueda Avanzada</span>
    <form action="/user" method="get" id="filterContainer" class="filter-container">
        <div class="row filters-menu">
            <div class="col-sm-12 col-md-3">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="buscar" class="col-sm-2 control-label">Buscar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="search"
                                   value="{{request('search')}}"
                                   id="buscar" placeholder="Búsqueda">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-3">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">

                            <select name="status" id="status" class="form-control">
                                @foreach($selects['user_status'] as $keyStatus => $status)
                                    @if(request('status'))
                                        @if($keyStatus === request('status'))
                                            <option value="{{$keyStatus}}" selected>{{$status}}</option>
                                        @else
                                            <option value="{{$keyStatus}}">{{$status}}</option>
                                        @endif
                                    @else
                                        @if($keyStatus === '0100')
                                            <option value="{{$keyStatus}}" selected>{{$status}}</option>
                                        @else
                                            <option value="{{$keyStatus}}">{{$status}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-12 col-md-3">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="show" class="col-sm-2 control-label">Mostrar</label>
                        <div class="col-sm-10">
                            <select name="show" id="show" class="form-control">
                                @foreach($selects['num_records'] as $keyNum => $num_record)
                                    @if(request('show'))
                                        @if($keyNum === request('show'))
                                            <option value="{{$keyNum}}" selected>{{$num_record.' Registros'}}</option>
                                        @else
                                            @if($keyNum === '0400')
                                                <option value="{{$keyNum}}">{{$num_record}}</option>
                                            @else
                                                <option value="{{$keyNum}}">{{$num_record.' Registros'}}</option>
                                            @endif
                                        @endif
                                    @else
                                        @if($keyNum === '0400')
                                            <option value="{{$keyNum}}" selected>{{$num_record}}</option>
                                        @else
                                            @if($keyNum === '0100')
                                                <option value="{{$keyNum}}">{{$num_record.' Registros'}}</option>
                                            @else
                                                <option value="{{$keyNum}}">{{$num_record.' Registros'}}</option>
                                            @endif

                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-3">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="order" class="col-sm-2 control-label">Orden</label>
                        <div class="col-sm-10">
                            <select type="text" class="form-control" name="order" id="order_by">
                                @foreach($selects['order_types'] as $keyOrder => $order)
                                    @if(request('order'))
                                        @if($keyOrder === request('order'))
                                            <option value="{{$keyOrder}}" selected>{{$order}}</option>
                                        @else
                                            <option value="{{$keyOrder}}">{{$order}}</option>
                                        @endif
                                    @else
                                        @if($keyOrder === '0100')
                                            <option value="{{$keyOrder}}" selected>{{$order}}</option>
                                        @else
                                            <option value="{{$keyOrder}}">{{$order}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-3">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="order" class="col-sm-2 control-label">Tipo de Rol</label>
                        <div class="col-sm-10">
                            <select type="text" class="form-control" name="rol" id="rol">
                                
                                @if(!request('rol'))
                                    <option value="0100" selected>Todos</option>
                                @endif
                                @if(request('rol') == '0100' && request('rol'))
                                    <option value="0100" selected>Todos</option>
                                @endif
                                @foreach($selects['roles'] as $rol)
                                    @if(request('rol'))
                                        @if($rol->id == request('rol'))
                                            <option value="{{$rol->id}}" selected>{{$rol->name}}</option>
                                        @else
                                            <option value="{{$rol->id}}">{{$rol->name}}</option>
                                        @endif
                                    @else
                                        <option value="{{$rol->id}}">{{$rol->name}}</option>
                                    @endif
                                @endforeach

                                @if(request('rol') && request('rol') != '0100')
                                    <option value="0100">Todos</option>
                                @endif

                            </select>
                        </div>
                    </div>
                </div>
            </div>

            @if(count($selects['centers']) > 1)
                <div class="col-sm-12 col-md-3">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="order" class="col-sm-2 control-label">Centro</label>
                            <div class="col-sm-10">
                                <select type="text" class="form-control" name="center" id="center">
                                    
                                    @if(!request('center'))
                                        <option value="0100" selected>Todos</option>
                                    @endif
                                    @if(request('center') == '0100' && request('rol'))
                                        <option value="0100" selected>Todos</option>
                                    @endif
                                    @foreach($selects['centers'] as $center)
                                        @if(request('center'))
                                            @if($center->id == request('center'))
                                                <option value="{{$center->id}}" selected>{{$center->name}}</option>
                                            @else
                                                <option value="{{$center->id}}">{{$center->name}}</option>
                                            @endif
                                        @else
                                            <option value="{{$center->id}}">{{$center->name}}</option>
                                        @endif
                                    @endforeach

                                    @if(request('center') && request('center') != '0100')
                                        <option value="0100">Todos</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row" id="btnRow">
            <div class="col-sm-12 col-md-2 col-md-offset-10">
                <div class="btn-group">
                    <button class="btn btn-sm btn-info" type="submit">
                        <i class="fa fa-search"></i>
                        Buscar
                    </button>
                    <a class="btn btn-sm btn-info" href="/user">
                        <i class="fa fa-eraser"></i>
                        Limpiar
                    </a>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <a href="/user/export/csv" type="button" class="btn btn-sm btn-info">
                <i class="fa fa-download"></i>
                Exportar a Excel
            </a>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <table class="table table-responsive list_table">
                <thead>
                    <tr>
                        <th class="text-center">Folio</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Centro de Trabajo</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Actualizar</th>
                        <th>Actualizar Contraseña</th>
                        @if(Auth::user()->role->id <= 3)
                            <th>Eliminar</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="text-center">
                            <a href="/user/{{ $user->id }}/details">
                                {{ $user->id }}
                            </a>
                        </td>
                        <td>
                            <a href="/user/{{ $user->id }}/details">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            {{ $user->center->name }}
                        </td>
                        <td>
                            @if($user->status == NULL)
                                <label class="label label-success">Activo</label>
                            @else
                                <label class="label label-danger">Eliminado</label>
                            @endif
                        </td>
                        <td>
                            {{ $user->role->name }}
                        </td>
                        <td>
                            <a href="#" ng-click="editDetails({{ json_encode($user) }}, {{ json_encode($selects['centers']) }}, {{ json_encode($selects['roles']) }})"><i class="fa fa-pencil-square-o"></i></a>
                        </td>
                        <td>
                            <a href="#" ng-click="updatePassword({{ json_encode($user) }})"><i class="fa fa-pencil-square-o"></i></a>
                        </td>
                        @if(Auth::user()->role->id <= 3)
                            <td>
                                @if($user->status == NULL)
                                    <a href="#" ng-click="deleteUser({{ json_encode($user) }})"><i class="fa fa-times"></i></a>
                                @else
                                    <a href="#" ng-click="activeUser({{ json_encode($user) }})"><i class="fa fa-check"></i></a>
                                @endif

                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(request('show')  !== '0400')
                {{ $users->links() }}
            @endif
        </div>
    </div>
        
    @include('user::user.partials.edit_details')
    @include('user::user.partials.edit_password')
    @include('user::user.partials.delete')
    @include('user::user.partials.active')
</div>
@endsection

@section('extra_scripts')

    <script>
        $(document).ready(function(){

            $("#status").on("change", function(){
                $("#filterContainer").submit();
            });

            $("#show").on("change", function(){
                $("#filterContainer").submit();
            });

            $("#order_by").on("change", function(){
                $("#filterContainer").submit();
            });

            $("#type").on("change", function(){
                $("#filterContainer").submit();
            });

            $("#rol").on("change", function(){
                $("#filterContainer").submit();
            });

            $("#center").on("change", function(){
                $("#filterContainer").submit();
            });

            /*$("#role").on("change", function(){
                $("#filterContainer").submit();
            });*/

        });
    </script>
        
    @include('layouts.angular', ['controller' => 'user']);
@endsection
