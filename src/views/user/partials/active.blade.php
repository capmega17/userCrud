<script type="text/ng-template" id="active.html">
    <div class="modal-header">
        <h3 class="modal-title">Activar Usuario</h3>
    </div>
    <div class="modal-body">
        <form id="activeForm" action="@{{ action_url }}" method="POST">
            {{ csrf_field() }}
            
            <input type="hidden" name="return_url" ng-value="return_url">
            
            <p>
                ¿Estás seguro que deseas activa al usuario "@{{ user.name }}"?
            </p>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="cancel()">Cancelar</button>
        <button class="btn btn-info" type="button" ng-click="ok()">Aceptar</button>
    </div>
</script>