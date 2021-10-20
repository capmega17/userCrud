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
                                        @if($keyNum === '0100')
                                            <option value="{{$keyNum}}" selected>{{$num_record.' Registros'}}</option>
                                        @else
                                            @if($keyNum === '0400')
                                                <option value="{{$keyNum}}">{{$num_record}}</option>
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

            {{-- <div class="col-sm-12 col-md-3">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="order" class="col-sm-2 control-label">Tipo Rol</label>
                        <div class="col-sm-10">
                            <select type="text" class="form-control" name="role" id="role">
                                <option value="1000" selected>Todos</option>
                                @foreach($selects['roles'] as $keyRol => $rol)
                                    @if(request('rol'))
                                        @if($keyRol === request('rol'))
                                            <option value="{{$keyRol}}" selected>{{$rol->name}}</option>
                                        @else
                                            <option value="{{$keyRol}}">{{$rol->name}}</option>
                                        @endif
                                    @else
                                        @if($keyRol === '1000')
                                            <option value="1000" selected>Todos</option>
                                        @else
                                            <option value="{{$keyRol}}">{{$rol->name}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div> --}}
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
                            {{ $user->status }}
                        </td>
                        <td>
                            {{ $user->role->name }}
                        </td>
                        <td>
                            <a href="#" ng-click="editDetails({{ json_encode($user) }}, {{ json_encode($selects['centers']) }}, {{ json_encode($selects['roles']) }})"><i class="fa fa-pencil-square-o"></i></a>
                        </td>
                        @if(Auth::user()->role->id <= 3)
                            <td>
                                <a href="#" ng-click="deleteUser({{ json_encode($user) }})"><i class="fa fa-times"></i></a>
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
        
    @include('user.partials.edit_details')
    @include('user.partials.delete')
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

            /*$("#role").on("change", function(){
                $("#filterContainer").submit();
            });*/

        });
    </script>
        
    @include('layouts.angular', ['controller' => 'user']);
@endsection
