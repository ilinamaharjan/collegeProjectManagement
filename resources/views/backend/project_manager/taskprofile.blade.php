@extends('backend.layouts.app')

@section('content')
<a href="{{ route('home.pm') }}"><button type="button" class="btn btn-primary convert mb-1"><i class="fa fa-arrow-left"
            aria-hidden="true">
            Back</i></button></a>
<div class="d-flex bd-highlight mb-3">
    <div class="align-self-center">

    </div>
    <div class="align-self-center mr-auto p-2 bd-highlight">

        <span class="input-group-text" style="background-color:transparent!important; border:none!important;"><i
                class="fa fa-calendar" style="background-color: white;
    padding: 10px;
    border-radius: 50%;"></i> <input placeholder="Select date" type="date" id="example_date" class="form-control"
                value="{{ $task['created_at'] == null ? '' : $task['created_at']->toDateString() }}" disabled></span>



    </div>

    {{-- <div class="p-2 bd-highlight"> <button type="button" class="btn btn-primary convert"><i class="fa fa-exchange"
                aria-hidden="true"></i>Convert</button></div> --}}
    <div class="p-2 bd-highlight"> <button type="button" class="pl-3 pr-3"
            style="background-color: ${element.favcolor}!important; border:1px solid ${element.favcolor}!important; color:${element.favcolor}!important; font-size:14px;">{{ $task->setting['status_name'] }}
            <i class="fa fa-angle-right" style="color:${element.favcolor} ;"></i></button></div>
</div>



<div class="bg-section">
    <div class="row" style="border-bottom:1px solid #eaeaea;">
        <div class="col-md-4">

            <div class="d-flex bd-highlight mb-3">



                <div class="align-self-center p-3 bd-highlight">
                    <h5 style="font-weight:600; font-size:12px;text-align:justify;">{{ $task['name'] }}</h5>
                    <span class="profile-sec"> {{ $task['project_name'] }} |
                        {{ $task->setting['status_name'] }} </span>
                </div>
            </div>

        </div>



        <div class="col-md-4">


            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Organization</h6>
                    <h6 style="font-weight:600; font-size:12px;">
                        {{ $task->company != null ? $task->company->name : '' }} </h6>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <i class="fa fa-building profile" aria-hidden="true"></i>
                </div>
                <div class="align-self-center p-3 bd-highlight">
                    <h6 class="profile-sec">Owner</h6>
                    <h6 style="font-weight:600; font-size:12px;">{{ $task->creator->name }}</h6>

                </div>
            </div>
        </div>

    </div>


    <ul class="nav nav-tab" role="tablist" style="border-bottom:1px solid #eaeaea;">



        <li class="nav-item">
            <div class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Description</span>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Sub tasks</span>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Assignees</span>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-5" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Status History</span>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Time Log</span>
                </div>
            </div>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content mt-5">
        <div class="tab-pane active" id="tabs-1" role="tabpanel">
            <div class="create_note  p-2">
                <form id="note_lead_form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <textarea name="description" class="form-control" cols="30"
                                rows="10">{{ $task['description'] }}</textarea>
                            <input type="text" name="id" value="{{$task['id']}}" hidden>
                        </div>
                        <div class="col-md-3">
                            <a onclick="updateTaskDescription()" class="btn btn-primary mt-3 pl-3 pr-3"
                                style="color:white;">Update</a>
                        </div>

                    </div>

                </form>
            </div>

        </div>
        <div class="tab-pane" id="tabs-2" role="tabpanel">
            <table class="table">
                <thead>
                    <th>Title</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Priority</th>
                </thead>
                <tbody id="dynamicSubTaskData">
                    @forelse ($sub_tasks as $sub_task)
                    <tr>
                        <td>{{ $sub_task['name'] }}</td>
                        <td>{{ $sub_task['deadline'] }}</td>
                        <td>
                            <select name="status_id" class="form-control" onchange="changeStatus({{$sub_task['id']}})">
                                @foreach ($project['leadSettings'] as $ls)
                                <option value="{{$ls['id']}}"
                                    {{($ls['id'] == $sub_task['status_id']) ? 'selected' : ''}}
                                    {{ ($completed_status == $sub_task['status_id']) ? 'disabled' : '' }}>
                                    {{ $ls['status_name'] }}</option>
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
                </tbody>
            </table>
            <form action="{{ route('task.storeSubTask') }}" method="POST" id="subTaskForm">
                @csrf
                <input type="text" value="{{$task['id']}}" name="parent_id" hidden>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Deadline</label>
                            <input type="datetime-local" name="deadline" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            {{-- <input type="text" name="deadline" class="form-control"> --}}
                            <select name="status_id" class="form-control">
                                @foreach ($project['leadSettings'] as $setting)
                                <option value="{{ $setting['id'] }}">{{$setting['status_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Assignees</label>

                            <select name="assignee[]" class="form-control">
                                @foreach ($users as $user)
                                <option value="{{ $user['id'] }}">
                                    {{ $user['id'] == auth()->id() ? 'Me' : $user['name']  }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="validateSubTask()">Save</button>
            </form>
        </div>
        <div class="tab-pane" id="tabs-3" role="tabpanel">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Assign this task to :</label>
                        <select name="assignee[]" class="form-control" id="assigneeHandler" multiple>
                            @foreach ($users as $user)
                            @if (in_array($user, $assignees))
                            <option value="{{ $user['id'] }}" selected>
                                {{$user['id'] == auth()->id() ? 'Me' : $user['name']}}</option>
                            @else
                            <option value="{{ $user['id'] }}">{{$user['id'] == auth()->id() ? 'Me' : $user['name']}}
                            </option>

                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" onclick="assignTeam({{$task['id']}},{{$project_id}})">Assign</button>
        </div>
        <div class="tab-pane" id="tabs-5" role="tabpanel">
            @forelse($task->histories as $history)
            @if($history->from == null)
            <li>Status changed to {{ $history->to->status_name }} <button
                    style="background-color: {{ $history->to->favcolor }}" disabled></button> by
                {{ $history->creator->name }} on
                {{ $history['created_at']->format('d-m-y') }}</li>
            @else
            <li>Status changed from <button style="background-color: {{ $history->from->favcolor }}" disabled> </button>
                {{ $history->from->status_name }} to <button style="background-color: {{ $history->to->favcolor }}"
                    disabled></button>
                {{ $history->to->status_name }} by {{ $history->creator->name }} on
                {{ $history['created_at']->format('d-m-y') }}</li>
            @endif
            @empty

            @endforelse
        </div>
        <div class="tab-pane" id="tabs-4" role="tabpanel">
            <table class="table">
                <thead>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Total Log Time (mins)</th>
                    <th>Action</th>
                </thead>
                <tbody id="dynamicLog">
                    <tr>
                        <form action="" id="timeLogForm">
                            <div class="row">
                                <input type="text" name="task_id" value="{{$task['id']}}" hidden>
                                <div class="col-md-3">
                                    <td><input type="datetime-local" name="actual_start_time" class="form-control" value="{{ $task['actual_start_time'] }}"></td>
                                </div>
                                <div class="col-md-3">
                                    <td><input type="datetime-local" name="actual_completed_time" class="form-control" value="{{ $task['actual_completed_time'] }}"></td>
                                </div>
                                <div class="col-md-3">
                                    <td><input type="number" min="0" name="log_time" class="form-control" value="{{ $task['log_time'] }}"></td>
                                </div>
                                <div class="col-md-3">
                                    <td>
                                        <button type="button" onclick="updateTimeLog()" class="btn btn-success">Update</button>
                                    </td>
                                </div>
                            </div>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex flex-row-reverse bd-highlight">


    </div>

</div>


{{-- <script src="{{asset('backend/js/custom.js')}}"></script> --}}
{{-- @include('{{asset('backend/js/customjs')}}') --}}
@include('backend/js/customjs')

<script>
    $(function () {
        $('.datepicker').datepicker({
            language: "es",
            autoclose: true,
            format: "dd/mm/yyyy"
        });
    });

    async function updateTimeLog(){
        let timeLogForm = document.getElementById('timeLogForm');
        let formData = new FormData(timeLogForm);
        let url = "{{route('ajax.storeTaskLog')}}";
        let requestOptions = {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            method: "POST",
            body: formData
        };
        let response = await fetch(url,requestOptions);
        if (response.status == 200) {
            let data = await response.json();
            if (data.response == true) {
                Swal.fire({
                    title: data.message,
                    icon: 'success',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: data.message,
                    icon: 'error',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }
        }
        debugger;
    }

    async function assignTeam(taskId,projectId) {
        debugger;
        let select = document.getElementById('assigneeHandler');
        const selectedOptions = [];
        for (const option of select.options) {
            if (option.selected) {
                selectedOptions.push(option.value);
            }
        }
        let formData = new FormData();
        formData.append('task_id',taskId);
        formData.append('assignee',selectedOptions);
        formData.append('status_setting_id',projectId);
        let url = "{{route('task.assignUser')}}";
        let requestOptions = {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            method: "POST",
            body: formData
        };
        let response = await fetch(url,requestOptions);
        if (response.status == 200) {
            let data = await response.json();
            if (data.response == true) {
                Swal.fire({
                    title: data.message,
                    icon: 'success',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: data.message,
                    icon: 'error',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }
        }
    }

    async function changeStatus(taskId) {
        let formData = new FormData();
        formData.append('status_id', event.target.value);
        formData.append('task_id', taskId);
        let url = "{{route('task.changeStatus')}}";
        let requestOptions = {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            method: "POST",
            body: formData
        };
        let response = await fetch(url, requestOptions);
        if (response.status == 200) {
            let data = await response.json();
            if (data.response == true) {
                let dynamicSubTaskData = document.getElementById('dynamicSubTaskData');
                if (dynamicSubTaskData.childElementCount > 0) {
                    dynamicSubTaskData.innerHTML = "";
                }
                dynamicSubTaskData.innerHTML = data.page;
                Swal.fire({
                    title: data.message,
                    icon: 'success',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            } else {
                Swal.fire({
                    title: data.message,
                    icon: 'error',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            }
        }
        debugger;

    }

    function validateSubTask() {
        let subTaskForm = document.getElementById('subTaskForm');
        let form = document.forms['subTaskForm'];
        let nameField = form['name'];
        let deadlineField = form['deadline'];
        let errCount = 0;
        let entries = [nameField, deadlineField];
        entries.forEach(element => {
            if (element.value == '') {
                errCount++;
                element.style.border = '1px solid red';
            } else {
                element.style.border = '1px solid #eaeaea';
            }
        });
        if (errCount == 0) {
            let url = "{{route('task.storeSubTask')}}";
            let formData = new FormData(subTaskForm);
            let requestOptions = {
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                method: "POST",
                body: formData
            };
            storeSubTask(url, requestOptions);
        } else {
            Swal.fire({
                title: 'Please fill the highlighted sub-task',
                icon: 'error',
                position: "top-right",
                timer: 3000,
                toast: true,
                showCancelButton: false,
                showConfirmButton: false
            })
        }
    }

    async function storeSubTask(url, requestOptions) {
        let response = await fetch(url, requestOptions);
        if (response.status == 200) {
            let data = await response.json();
            if (data.response == true) {
                let dynamicSubTaskData = document.getElementById('dynamicSubTaskData');
                if (dynamicSubTaskData.childElementCount > 0) {
                    dynamicSubTaskData.innerHTML = "";
                }
                dynamicSubTaskData.innerHTML = data.page;
                Swal.fire({
                    title: data.message,
                    icon: 'success',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            } else {
                Swal.fire({
                    title: data.message,
                    icon: 'error',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            }
            debugger;
        }
    }

    async function changeActivityStatus(activityId) {
        let formData = new FormData();

        let defaultStatus = 'Ongoing';
        if (event.target.checked == true) {
            defaultStatus = 'Completed';
        }

        formData.append('activity_id', activityId);
        formData.append('status', defaultStatus);
        let url = "{{ route('ajax.changeActivityStatus') }}";
        let requestOptions = {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            method: "POST",
            body: formData
        };

        let response = await fetch(url, requestOptions);
        if (response.status == 200) {
            let data = await response.json();
            if (data.response == true) {
                Swal.fire({
                    title: data.message,
                    icon: 'success',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            } else {
                Swal.fire({
                    title: data.message,
                    icon: 'error',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            }

        }
    }

    function toggleFiles() {
        let idVal = event.target.value;
        getRespectiveFiles(idVal);
    }

    async function updateTaskDescription() {
        let form = document.getElementById('note_lead_form');
        let formData = new FormData(form);
        let url = "{{route('task.updateDescription')}}";
        let requestOptions = {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            method: "POST",
            body: formData
        };

        let response = await fetch(url, requestOptions);
        if (response.status == 200) {
            let data = await response.json();
            if (data.response == true) {
                Swal.fire({
                    title: data.message,
                    icon: 'success',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            } else {
                Swal.fire({
                    title: data.message,
                    icon: 'error',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            }
            debugger
        }
        debugger
    }

</script>



@endsection
