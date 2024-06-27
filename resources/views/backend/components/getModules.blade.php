
<div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Modules associated with the package: </h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
        <div class="p-3">
            <table class="table">
                <thead>
                    <th>S.No</th>
                    <th>Module Name</th>
                </thead>
                <tbody>
                    @forelse ($modules as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->display_name }}</td>
                        </tr>
                    @empty
                        
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
  </div>