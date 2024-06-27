<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Task Update Notice by :- [{{$additional_data['creator']}}]</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body text-dark" style="max-height: 500px; overflow-x:hidden">
        <p class="mt-2">{{ $additional_data['created'] == 0 ? 'Task has been updated from '.$additional_data['from'].' to '.$additional_data['to'].'. ' : 'Task has been created. '}} The task summary report is presented below : </p>
       <div class="table-responsive">
    
        <table class="table  text-dark" style="width:100%">
            <thead>
                <tr>
                    <th >Name</th>
                    <th >Description</th>
                    <th >Deadline</th>
                    <th >Project</th>
                </tr>
            </thead>
            <tbody>
                <tr>
    
                    <td>   {{ $additional_data['task']->name }}</td>
                    <td> {{ $additional_data['task']->description }}</td>
                    <td> {{ $additional_data['task']->deadline }}</td>
                    <td>Impexo</td>
                </tr>
    
            </tbody>
        </table>
    
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>
