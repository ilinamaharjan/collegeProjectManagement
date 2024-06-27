<div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Permissions for
        {{$user->name}}</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
        <div class="row" id="permissioncall">
            @forelse ($permission_of_users as $pky=>$per)
            <div class="col-lg-6 p-2"><b>{{$pky+1}}.</b> {{$per->name}}</div>

            @empty
            <div class="col-lg-6 p-2">Permission not found</div>

            @endforelse
        </div>
    </div>
   
</div>