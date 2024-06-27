<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Status History - {{ $lead->title }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="row d-flex justify-content-around p-2">
        <div class="col-md-10 ">
        <div class="tab-pane" id="tabs-5" role="tabpanel">
            @forelse($status_histories as $history)
            
            @if($history->from == null)
            <li>Status changed to <b> {{ $history->to->status_name }}</b> <button
                    style="background-color: {{ $history->to->favcolor }}" disabled></button> by
                {{ $history->creator->name }} on
                {{ $history['created_at']->format('d-m-y') }} </li>
            @else
            <li>Status changed from <button style="background-color: {{ $history->from->favcolor }}" disabled> </button>
                <b>{{ $history->from->status_name }}</b> to <button style="background-color: {{ $history->to->favcolor }}"
                    disabled></button>
               <b> {{ $history->to->status_name }}</b> by {{ $history->creator->name }} on
                {{ $history['created_at']->format('d-m-y') }}</li>
            @endif
            @empty

            @endforelse
        </div>
    </div>
    </div>

</div>