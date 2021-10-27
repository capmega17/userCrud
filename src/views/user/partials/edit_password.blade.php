<script type="text/ng-template" id="updatePassword.html">
    <div class="modal-header">
        <h3 class="modal-title">Cambiar Contraseña al Usuario</h3>
    </div>
    <div class="modal-body">
        <form id="updatePasswordForm" action="@{{ action_url }}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="return_url" ng-value="return_url">

            <div class="form-group">
                <label>
                    Ingrese una nueva contraseña al usuario "@{{ user.name }}"
                </label>
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