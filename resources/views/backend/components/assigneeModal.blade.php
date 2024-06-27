<div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Assignee : </h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
        @foreach ($data as $item)
            <div class="row">
              <div class="col-md-6">
                <p><a href="javascript:;" onclick="renderAssignees({{$item['id']}},'{{ route('ajax.getAssigneesTask') }}')">{{ $item['name'] }}</a></p>
              </div>
              <div class="col-md-6">
                <p>Tasks count : {{ $item['task_count'] }}</p>
              </div>
            </div>
        @endforeach
    </div>
    <div class="modal-footer">
    </div>
</div>