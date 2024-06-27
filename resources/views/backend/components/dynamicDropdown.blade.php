<label class="form-label">Status</label>
<select name="lead[status_id]" class="form-control">
    @forelse ($lead_settings as $item)
        <option value="{{ $item->id }}">{{ $item->status_name }}</option>
    @empty
        <option value="">No data</option>
    @endforelse
</select>