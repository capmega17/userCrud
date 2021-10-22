<script type="text/ng-template" id="editDetails.html">
    <div class="modal-header">
        <h3 class="modal-title">Editar Detalles del Usuario</h3>
    </div>
    <div class="modal-body">
        <form id="detailForm" action="@{{ action_url }}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="return_url" ng-value="return_url">

            <div class="form-group">
                <label for="">Nombre Completo</label>
                <input type="text" class="form-control" name="name" id="name" ng-model="user.name">
            </div>
            {{-- <div class="form-group">
                <label for="">Apellido</label>
                <input type="text" class="form-control" name="last_name" id="last_name" ng-model="user.last_name">
            </div> --}}
            <div class="form-group">
                <label for="">Correo</label>
                <input type="text" class="form-control" name="email" id="email" ng-model="user.email">
            </div>
            <div class="form-group">
                <label for="">Rol de Usuario</label>
                <select class="form-control" id="role" name="role" ng-options="roles.name for roles in roles track by roles.id" ng-model="user.role">
                    <option value="" hidden>Selecciona un Tipo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Lugar de Trabajo</label>
                <select class="form-control" id="center" name="center" ng-options="centers.name for centers in centers track by centers.id" ng-model="user.center">
                    <option value="" hidden>Selecciona un Tipo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Nueva Contraseña</label>
                 <input type="password" class="form-control" name="password">
                </select>
            </div>

            <div class="form-group">
                <label for="">Repetir Contraseña</label>
                 <input type="password" class="form-control" name="password_confirm">
                </select>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="cancel()">Cancelar</button>
        <button class="btn btn-info" type="button" ng-click="ok()">Aceptar</button>
    </div>
</script>