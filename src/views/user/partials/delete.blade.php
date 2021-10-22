<script type="text/ng-template" id="delete.html">
    <div class="modal-header">
        <h3 class="modal-title">Eliminar Usuario</h3>
    </div>
    <div class="modal-body">
        <form id="deleteForm" action="@{{ action_url }}" method="POST">
            {{ csrf_field() }}
            
            <input type="hidden" name="return_url" ng-value="return_url">
            
            <p>
                ¿Estás seguro que deseas eliminar al usuario "@{{ user.name }}"?
            </p>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="cancel()">Cancelar</button>
        <button class="btn btn-info" type="button" ng-click="ok()">Aceptar</button>
    </div>
</script>