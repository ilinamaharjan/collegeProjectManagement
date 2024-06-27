<div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Permissions for
        {{$role->name}}</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
        <div class="row" id="permission call">
            @forelse($role['permissions'] as $pk=> $permission)
            <div class="col-lg-6 p-2"><b>{{$pk+1}}.</b> {{$permission->name}}</div>
            @empty
            Permissions Not Found!

            @endforelse
        </div>

    </div>
   
</div>