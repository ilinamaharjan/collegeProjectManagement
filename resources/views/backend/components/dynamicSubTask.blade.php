@forelse ($sub_tasks as $sub_task)
    <tr>
        <td>{{ $sub_task['name'] }}</td>
        <td>{{ $sub_task['deadline'] }}</td>
        <td>
            <select name="status_id" class="form-control" onchange="changeStatus({{$sub_task['id']}})">
                @foreach ($project['leadSettings'] as $ls)
                    <option value="{{$ls['id']}}" {{($ls['id'] == $sub_task['status_id']) ? 'selected' : ''}} {{ ($completed_status == $sub_task['status_id']) ? 'disabled' : '' }}>{{ $ls['status_name'] }}</option>
                @endforeach
            </select>
        </td>
        <td>{{ $sub_task['priority'] }}</td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center">No data</td>
    </tr>
@endforelse