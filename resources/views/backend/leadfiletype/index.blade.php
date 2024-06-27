@extends('backend.layouts.app')

@section('content')
<div class="bg-section">
    <ul class="nav nav-tab" role="tablist" style="border-bottom:1px solid #eaeaea;">
        <li class="nav-item">
            <div class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">File Type Setting
                    </span>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <div class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">
                <div style="border-right:1px solid #eaeaea;">
                    <i class="fa fa-building profile" aria-hidden="true"></i> <span class="p-2">Email Settings</span>
                </div>
            </div>
        </li>
    </ul>



    <div class="tab-content">
        <div class="tab-pane active" id="tabs-1" role="tabpanel">

            {{-- <div class="row"> --}}

            <div class="p-3">
                <form action="{{ route('leadfiletype.store') }}" method="POST" id="filetype_form">
                    @csrf
                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group" id="contact_person">
                                <label class="form-label">File Type Name <sup class="text-danger">*</sup></label>
                                <input type="text" id="name" class="form-control" name="name">
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="check_multiple">
                                <label class="form-label">Has multiple file type?</label>
                                <input type="checkbox" id="has_multiple" name="has_multiple"
                                    onclick="hasMultipleField()" checked> <br>
                                <p>Click on the box for multiple file type.</p>

                            </div>
                        </div>
                        <div class="px-3">

                            <p id="err" class="text-danger"></p>
                        </div>

                    </div>
                    {{-- <button type="submit" onclick="submitLeadFileTypeForm()"
                                class="btn btn-primary lead">Submit</button> --}}
                    <button type="button" onclick="submitLeadFileTypeForm()"
                        class="btn btn-primary lead">Submit</button>
                </form>
            </div>
            <hr>
            <script>
                function submitLeadFileTypeForm() {
                    let form = document.getElementById('filetype_form');
                    let name = document.getElementById('name');
                    debugger;
                    if (name.value == '') {
                        name.style.border = '1px solid red';
                        document.getElementById('err').innerText =
                            `Please fill the empty field`;
                    } else {
                        name.style.border = '1px solid #cacaca';
                        document.getElementById('err').innerText =
                            ``;
                        form.submit();
                    }
                }

            </script>

            {{-- </div> --}}

            {{-- <table class="table table-light">
                    <thead class="text-dark">
                        <th>S.no</th>
                        <th>Name</th>
                        <th>Has Multiple</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if (count($filetypes) > 0)
                            @foreach ($filetypes as $key => $filetype)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
            <td>{{ $filetype->name }}</td>
            <td>
                @if ($filetype->has_multiple == 1)
                True
                @else
                False
                @endif
            </td>
            <td>
                <i class="fa fa-edit customer"></i>
                <i class="fa fa-trash customer"></i>
            </td>

            </tr>
            @endforeach
            @else
            not found.
            @endif

            </tbody>
            </table> --}}

        </div>
        <div class="tab-pane" id="tabs-2" role="tabpanel">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Notification for Project Manager</h5>
                        </div>
                        <div class="card-body">
                            <form action="" id="pmForm">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                      <input class="form-check-input me-1" name="mail_to_creator" type="checkbox" value="" aria-label="...">
                                      1. Send mail to creator.
                                    </li>
                                    <li class="list-group-item">
                                      <input class="form-check-input me-1" name="mail_to_assignees" type="checkbox" value="" aria-label="...">
                                      2. Send mail to assignees.
                                    </li>
                                </ul>
                            </form>
                            <button class="btn btn-success mt-4" type="button" onclick="updateSettings('pm')">Update</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-3"></div>
            </div>
        </div>
    </div>


</div>
@endsection

<script>
    async function updateSettings(moduleType) {
        const form = moduleType == 'pm' ? document.getElementById('pmForm') : document.getElementById('dealForm');
        let formElements = [...form.elements];        
        let formData = new FormData();
        formElements.forEach(element => {
            element.checked ? formData.append(element.name,1) : formData.append(element.name,0);
        });
        formData.append('module_type',moduleType);
        let url = "{{route('email_settings.store')}}";
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
</script>
