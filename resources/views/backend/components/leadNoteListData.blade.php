@foreach ($notes as $note)
    <div class="d-flex justify-content-between">
        @if ($note->is_important == 1)
            <i class="fa fa-star-half-o" aria-hidden="true">
        @endif
        <span class="lead-note ml-3">{{ $note->notes }} </span></i>

        <span class="input-group-text"
            style="background-color:transparent!important; border:none!important;padding:0px!important;"><i
                class="fa fa-calendar" style="background-color: #ddd;

    border-radius: 50%;"></i>
            <!-- <label>Uploaded</label> -->
            <input placeholder="Select date" type="date" id="example_date" class="form-control"
                value="{{ $note['created_at'] == null ? '' : $note['created_at']->toDateString() }}" disabled></span>
    </div>
@endforeach
