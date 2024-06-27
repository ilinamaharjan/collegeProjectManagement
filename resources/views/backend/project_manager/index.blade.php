@extends('backend.layouts.app')
@section('content')
<style>
    select.form-control:not([size]):not([multiple]) {
        height: 36px !important;
    }

    /* Remove the default background */


    input[type="color"] {
        -webkit-appearance: none;
        border: none;
    }

    input[type="color"]::-webkit-color-swatch-wrapper {
        padding: 0;
    }

    input[type="color"]::-webkit-color-swatch {
        border: none;
    }

</style>

<div class="row">
    <div class="col-md-6">
        <div class="d-flex bd-highlight mb-3">

            <div class=" bd-highlight">
                <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#first-modal">
                    <i class="fa fa-plus" aria-hidden="true"></i> PROJECT
                </button>
                <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#dynamicModal"
                    onclick="addTaskDynamic()">
                    <i class="fa fa-plus" aria-hidden="true"></i> TASK
                </button>
                
            </div>
            <div>
                <select name="status" class="form-control ml-3" id="categorySelector" onchange="renderRespectiveSettings()">
                    @forelse($categories as $category)
                    <option value="{{ $category->id }}">{{ $category['name'] }}</option>
                    @empty
        
                    @endforelse
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex bd-highlight mb-3">
            <div class="mr-auto bd-highlight">
                <button type="button" class="btn" onclick="renderAssignees({{auth()->id()}},'{{ route('ajax.getAssigneesTask') }}')">
                    <i class="fa fa-user"></i> ME
                </button>
                <button type="button" class="btn" data-toggle="modal" data-target="#commonModal" onclick="assigneesModal()">
                    <i class="fa fa-users"></i> Assignees
                </button>
                <button type="button" class="btn" onclick="viewAllRespectiveTask()">
                    <i class="fa fa-users"></i> ALL
                </button>
            </div>
        </div>
    </div>
</div>





<div class="row">
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content p-3" style="border-radius:25px;">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Add New Task</h5>
                    <!-- <p>Add Lead to your contact</p> -->

                    <button type="button" class="close" data-dismiss="modal"
                        onclick="refreshTaskModal('firstForm')">&times;</button>
                </div>

                <!-- Modal body -->
                <form action="" id="firstForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control lead1Data">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Deadline</label>
                                    <input type="datetime-local" name="deadline" class="form-control lead1Data">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="lead[status_id]" id="status_id" value="" hidden>
                                    <label class="form-label">Status Type</label>
                                    <input type="text" class="form-control" name="status_id" value="" id="status_val"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Priority Level</label>

                                    <select name="priority" class="form-control">
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Assignees</label>

                                    <select name="assignee[]"  class="form-control" multiple>
                                        @foreach ($users as $user)
                                            <option value="{{ $user['id'] }}">{{ $user['id'] == auth()->id() ? 'Me' : $user['name']  }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Additional Description</label>
                                    <textarea name="description" class="form-control lead1Data" cols="30"
                                        rows="10"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="flex mt-5 mb-3 me-auto">

                        <button type="button" class="btn btn-primary convert" data-toggle="modal" data-target="#myModal"
                            style="width:45%;" onclick="refreshTaskModal('firstForm')">Cancel</button>
                        <button type="button" onclick="storeTask('{{ route('task.store') }}','firstForm')"
                            class="btn btn-primary save" style="width:45%;">Save</button>
                    </div>
                    <p class="mt-2 text-danger" id="leadFormError1"></p>

                </form>

            </div>

            <!-- Modal footer -->

        </div>
    </div>
    <div class="modal" id="dynamicModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content p-3" style="border-radius:25px;">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Add New Task</h5>
                    <!-- <p>Add Lead to your contact</p> -->

                    <button type="button" class="close" data-dismiss="modal"
                        onclick="refreshTaskModal('secondForm')">&times;</button>
                </div>

                <!-- Modal body -->
                <form action="" id="secondForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control leadData">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Deadline</label>
                                    <input type="datetime-local" name="deadline" class="form-control leadData">
                                </div>
                            </div>

                            <!-- toggle -->




                            <div class="col-md-6" id="dynamicDiv">

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Priority Level</label>

                                    <select name="priority" class="form-control">
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Assignees</label>

                                    <select name="assignee[]"  class="form-control" multiple>
                                        @foreach ($users as $user)
                                            <option value="{{ $user['id'] }}">{{ $user['id'] == auth()->id() ? 'Me' : $user['name']  }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Additional Description</label>
                                    <textarea name="description" class="form-control leadData" cols="30"
                                        rows="10"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="flex mt-5 mb-3 me-auto">

                        <button type="button" class="btn btn-primary convert" data-toggle="modal"
                            data-target="#dynamicModal" style="width:45%;"
                            onclick="refreshTaskModal('secondForm')">Cancel</button>
                        <button type="button" onclick="storeTask('{{ route('task.store') }}','secondForm')"
                            class="btn btn-primary save" style="width:45%;">Save</button>
                    </div>

                    <p class="mt-2 text-danger" id="leadFormError"></p>
                </form>

            </div>

        </div>
    </div>

    <!-- Modal footer -->

</div>
</div>

{{-- Drag and Drop Section --}}
<table class="paymentTable" id="dragTable">

    <tr id="statusSettingContainerDiv">



    </tr>



    <tr id="leadContainerDiv">

    </tr>
</table>

{{-- Categories and Status Section --}}
<div class="container text-center">

    


    <div class="modal" id="first-modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog model-lg">
            <div class="modal-content" style="border-radius:8px;box-shadow: 6px 4px 42px -4px rgba(66, 71, 200, 0.53);">
                <div class="modal-header d-flex justify-content-between align-items-start">

                    <div>
                        <h5 class="modal-title"
                            style="font-size: 16px;color:#131540;line-height:19.36px;font-weight:700" id="myModalLabel">
                            Add New Project<br>
                            <p class="catagories ml-4 mt-2" style="font-size: 12px;color:#ACACAC">Add new status to the
                                project</p>
                        </h5>
                    </div>
                    <div>

                        <button type="button" style="background:none;color:#4D4D4D !important;" class="close"
                            data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form action="{{ route('lead_setting.store') }}" id="leadStatusForm" method="POST">
                    @csrf
                    <div class="modal-body" id="settingDiv">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label"
                                        style="color:#131540;font-size: 11px;line-height:13.31px;font-weight:700;float:left;">Projects<sup>*</sup></label>
                                    <select class="form-select form-control statusSettings" id="statusSettings"
                                        name="statusSettingId" style="width:100%;border-radius:20px !important">
                                        <option selected>Choose...</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label"
                                        style="color:#131540;font-size: 11px;line-height:13.31px;font-weight:700;float:left;"></label>
                                    <button type="button"
                                        class="btn-second-modal within-first-modal btn btn-primary lead"
                                        style="font-size: 11px;line-height:13.31px;margin-top:38px;">
                                        + PROJECT
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-success btn-add float-right" onclick="addRow()"
                                        style="text-align:center;line-height: 18.15px;font-size:15px;font-weight:400;color:#131540"
                                        type="button">
                                        <i class="fa fa-plus" style="margin: auto" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label"
                                            style="color:#131540;font-size: 11px;line-height:13.31px;font-weight:700;float:left;">Status
                                            Name <sup>*</sup></label>
                                        <input type="text" class="form-control status_name" placeholder="name"
                                            name="status_name[]">

                                    </div>
                                </div>

                                <div class="col-md-12 d-flex justify-content-around">
                                    <div>
                                        <label
                                            style="color:#131540;font-size: 11px;line-height:13.31px;font-weight:700;float:left;">Hierachy
                                            <sup>*</sup> </label>
                                        <input type="text" class="form-control heirarchy_order" placeholder="hierarchy"
                                            name="heirarchy0" id="heirarchy0" style="width:100%;">
                                    </div>
                                    <div>
                                        <div class="input-group-text"
                                            style="margin-top:35px;background:white;border:1px solid #eaeaea"><span
                                                style="margin-left:8px!important; font-size:10px;font-weight:500;color:#999">Begin</span>
                                            <input class="form-check-input mt-0 notclickedf" type="radio" value="First"
                                                aria-label="Radio button for following text input"
                                                style="margin-left:-6px!important;" name="first_radio0"
                                                id="first_radio0" onclick="toggleRadio(0)">
                                        </div>
                                    </div>

                                    <div>
                                        <div class="input-group-text"
                                            style="margin-top:35px;background:white;border:1px solid #eaeaea"><span
                                                style="margin-left:8px!important; font-size:10px;font-weight:500;color:#999">Closed</span>
                                            <input class="form-check-input mt-0 notclickedl" type="radio" value="Last"
                                                aria-label="Radio button for following text input"
                                                style="margin-left:-6px!important;" name="last_radio0" id="last_radio0"
                                                onclick="toggleRadio(0)">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="input-group-text"
                                            style="margin-top:35px;background:white;border:1px solid #eaeaea"><span
                                                style="margin-left:8px!important; font-size:10px;font-weight:500;color:#999">None</span>
                                            <input class="form-check-input mt-0 notclickedn" type="radio" value=""
                                                aria-label="Radio button for following text input"
                                                style="margin-left:-6px!important;" name="none_radio0" id="none_radio0"
                                                onclick="toggleRadio(0)">
                                        </div>
                                    </div>


                                    <div>
                                        <div style="margin-top:-7px;">

                                            <input type="color" id="favcolor" name="favcolor[]" value="#E46262"><br><br>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!--  -->
                    <div class="modal-footer" style="justify-content: flex-center!important;border:none">
                        <button type="button"
                            style="border-radius: 35px;border: 1px solid #D7D7D7;font-size: 13px;font-weight: 700;"
                            class="btn btn-default close" data-dismiss="modal">Cancel</button>
                        <button type="button" onclick="submitStatus()" class="btn btn-default save"
                            style="border-radius: 35px;border: 1px solid rgba(44, 80, 124, 1);background-color:rgba(44, 80, 124, 1);font-size: 13px;font-weight: 700;">Save</button>
                    </div>
                </form>
            </div>
        </div>
        </form>


    </div>

    <div class="modal" id="second-modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <form action="" id="categoryFormStat">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add new catagories
                            <br>
                            <p class="catagories">Add new catagories to State</p>
                        </h5>
                        <button type="button" class="btn-second-modal-close close"><span
                                aria-hidden="true">&times;</span></button>

                    </div>
                    <div class="modal-body">
                        <input type="text" name="module" value="pm" hidden>
                        <div class="row">
                            <div class="col-md-12">
                                <label style="float:left;">State Catagories <sup>*</sup> </label>
                                <input type="text" class="form-control" placeholder="name" name="name"
                                    style="width:100%;">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" style="justify-content: flex-center!important;">
                        <button type="button" class="btn btn-default save" onclick="submitCategory()">Save</button>
                        <button type="button" class="btn btn-default close" data-dismiss="modal">Cancel</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let categoryId = null;
    let categoryName = '';
    
    let assigneeTogglerObj = {
        viewMe : false,
    };

    let idArr = [];
    window.addEventListener('load', () => {
        let jsonData = @json($categories, JSON_PRETTY_PRINT);
        if (jsonData.length > 0) {
            renderRespectiveSettings(jsonData[0].id);
        }

        let tdClassDiv = document.getElementsByClassName('tdPayment');

    });

    async function addTaskDynamic() {
        let url = "{{ route('ajax.getLeadStatus','something') }}";
        let newUrl = url.replace('something', categoryId);
        debugger;
        let response = await fetch(newUrl);
        if (response.status == 200) {
            let data = await response.json();
            if (data.response == true) {
                let dynamicDiv = document.getElementById('dynamicDiv');
                dynamicDiv.innerHTML = data.page;
            } else {
                alert(data.message);
            }
            debugger;
        }
    }

    function refreshTaskModal(type) {
        let leadsData = type == 'secondForm' ? Array.from(document.getElementsByClassName('leadData')) : Array.from(document.getElementsByClassName('lead1Data'));
        
        let entries = [...leadsData];
        entries.forEach(element => {
            if (element.tagName == 'SELECT') {
                element.value = element.options[0].value;
            } else {
                element.value = '';
            }
            element.style.border = '1px solid #eaeaea';
        });
        

        let errorDiv = type == 'secondForm' ? document.getElementById('leadFormError') : document.getElementById('leadFormError1');
        errorDiv.textContent = '';
        

    }

    function assigneesModal(){
        let statusSettingID = document.getElementById('categorySelector').value;
        let url = "{{route('task.getAssignee','something')}}";
        let newUrl = url.replace("something", statusSettingID);
        try {
            loadModal(newUrl);
        } catch (error) {
            debugger;
        }
    }

    function validateTaskForm(formId) {
        let leadsData = formId == 'secondForm' ? Array.from(document.getElementsByClassName('leadData')) : Array.from(
            document.getElementsByClassName('lead1Data'));
        let errCount = 0;
        leadsData.forEach(element => {
            if (element.value == '') {
                errCount++;
                element.style.border = '1px solid red';
            } else {
                element.style.border = '1px solid #eaeaea';
            }
        });
        if (errCount > 0) {
            return false;
        } else {
            return true;
        }
    }

    function addTask(id, name) {
        let statusType = document.getElementById('status_val');
        let statusId = document.getElementById('status_id');
        statusType.value = name;
        statusId.value = id;
    }

    async function storeTask(url, formId) {
        let form = document.getElementById(formId);
        let formData = new FormData(form);
        validationResponse = validateTaskForm(formId);
        if (validationResponse == true) {
            let requestOptions = {
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                method: "POST",
                body: formData
            };
            let response = await fetch(url, requestOptions);
            debugger;
            if (response.status == 200) {
                let data = await response.json();
                debugger;
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
                    renderRespectiveSettings(data.category_id);
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
        } else {
            let errorDiv = formId == 'secondForm' ? document.getElementById('leadFormError') : document
                .getElementById('leadFormError1');
            errorDiv.textContent = 'Please fill the fields';
        }
    }

    function viewAllRespectiveTask() {
        let statusSettingID = document.getElementById('categorySelector').value;
        assigneeTogglerObj.viewMe = false;
        renderRespectiveSettings(statusSettingID);
    }

    async function renderAssignees(userId,url){
        assigneeTogglerObj.viewMe = true;
        let statusSettingID = document.getElementById('categorySelector').value;
        let formData = new FormData();
        formData.append('user_id',userId);
        formData.append('status_setting_id',statusSettingID);
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
            debugger
            if (data.data.length > 0) {
                let statData = data.data;
                let statusSettingContainerDiv = document.getElementById('statusSettingContainerDiv');
                statusSettingContainerDiv.childElementCount > 0 ? statusSettingContainerDiv.innerHTML = '' :
                    statusSettingContainerDiv;
                let leadContainerDiv = document.getElementById('leadContainerDiv');
                leadContainerDiv.childElementCount > 0 ? leadContainerDiv.innerHTML = '' : leadContainerDiv;

                statData.forEach(element => {
                    let name = element.status_name.trim();
                    let newname = name.replace(' ', '_') + '_' + element.id;
                    let th = document.createElement('th');
                    let td = document.createElement('td');
                    th.classList.add('thPayment');
                    td.classList.add('tdPayment');
                    td.id = newname;
                    idArr.push(newname);
                    let localURL = "{{env('APP_URL')}}";
                    th.innerHTML = `

                    
                        <div class="lead_box" style="border-right:10px solid ${element.favcolor} !important;">
   
                                
                                <div class="menu-nav">
        <div class="menu-item">
        <h6 class="mt-1 lead-progress" style="color:${element.favcolor}!important;">${element.status_name}
        <span class="badge badge-light mb-3">${ element.tasks.length }</span></h6>
        </div>
        <div class="dropdown-container" tabindex="-1">
          <div class="three-dots"></div>
          <div class="dropdown">
            <a href="#"><div class="activity-dot">Convert</div></a>
            <a href="#"><div class="activity-dot">Complete</div></a>
            <a href="#"><div class="activity-dot">Progress</div></a>
          </div>
        </div>
      </div>
                               
                          
                        </div>
                        <a href="" data-toggle="modal" data-target="#myModal" onclick="addTask(${element.id},'${element.status_name}')"><p class="mt-3" style="text-align:center;"> + Add ${element.status_name} </p></a>

                        
                    `;
                    let tasks = element.tasks;
                    debugger;
                    if (tasks.length > 0) {
                        let indexCount = 0;
                        tasks.forEach(task => {
                            let assignees = task.users;
                            let assigneeToolTip = ``;
                            if (assignees.length == 0) {
                                assigneeToolTip = ` Assignees : ${assignees.length} `;                                
                            } else {
                                assigneeToolTip = ` Assignees : `;

                                assignees.forEach((assignee,index) => {
                                    if (index == 0) {
                                        assigneeToolTip = assigneeToolTip + `${assignee.name}`;
                                    } else {
                                        assigneeToolTip = assigneeToolTip + `, ${assignee.name}`;
                                    }
                                });
                            }
debugger
                            indexCount++;
                            let rowDiv = document.createElement('div');
                            let div = document.createElement('div');
                            div.classList.add('lead_box1');
                            // if (lead.is_converted == 1) {
                            //     div.setAttribute('draggable', false);
                            // } else {
                            //     div.setAttribute('draggable', true);
                            // }
                            div.setAttribute('draggable', true);
                            div.setAttribute('ondragstart', 'dragStart()');
                            div.setAttribute('id', `lead_box_${task.id}`);
                            rowDiv.classList.add('row');
                            rowDiv.innerHTML = `
                            
                            
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <a href="/taskprofile/${task.id}">
                                            <h5 class="lead-ti">${ task.name.length >= 30 ? task.name.slice(0,30)+'...' :  task.name }</h5>
                                            <i class="fa fa-user mt-2" data-bs-toggle="tooltip" data-bs-placement="top" title="${assigneeToolTip}"></i>
                                            <span><i class="fa fa-flag text-danger mt-2 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Priority : ${task.priority}"></i></span>
                                        </a>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="menu-nav" style="float:right;">
                                            <div class="dropdown-container" tabindex="-1" style="float:right;">
                                                <div class="three-dots"></div>
                                                <div class="dropdown">
                                                    <a href="#">
                                                        <div class="activity-dot">Cancel</div>
                                                    </a>
                                                    <a href="#">
                                                        <div class="activity-dot">Halt</div>
                                                    </a>
                                                    <a href="#">
                                                        <div class="activity-dot">Add Handler</div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>



                            <div class="d-flex bd-highlight mt-3 p-3">
                                <div class="flex-fill bd-highlight">

                                    <span class="input-group-text"
                                        style="background-color:transparent!important; border:none!important; padding:0px;">
                                        <i class="fa fa-calendar deal"> ${task.deadline.split('T')[0]}</i>
                                </div>
                            </div>

                  
                            `;

                            div.appendChild(rowDiv);
                            td.appendChild(div);
                        });
                    } else {

                    }
                    statusSettingContainerDiv.appendChild(th);
                    leadContainerDiv.appendChild(td);
                });

                idArr.forEach(id => {
                    let box = document.getElementById(id);
                    box.setAttribute('ondrop', "drop('{{ route('ajax.updateTask') }}')");
                    box.setAttribute('ondragover', 'allowDrop()');
                });
            }
        }
        $('#commonModal').modal('hide');
        $(".modal-backdrop").hide();
    }

    async function renderRespectiveSettings(data = null) {
        idArr = [];
        if (data != null) {
            categoryId = data;
            // categoryName = data.name;
        } else {
            categoryId = event.target.value;
            // categoryName = event.target.selectedOptions[0].text;
        }
        let url = "{{ route('ajax.getTask','something') }}";
        let newUrl = url.replace("something", categoryId);
        let response = await fetch(newUrl);
        if (response.status == 200) {
            let data = await response.json();
            debugger
            if (data.data.length > 0) {
                let statData = data.data;
                let statusSettingContainerDiv = document.getElementById('statusSettingContainerDiv');
                statusSettingContainerDiv.childElementCount > 0 ? statusSettingContainerDiv.innerHTML = '' :
                    statusSettingContainerDiv;
                let leadContainerDiv = document.getElementById('leadContainerDiv');
                leadContainerDiv.childElementCount > 0 ? leadContainerDiv.innerHTML = '' : leadContainerDiv;

                statData.forEach(element => {
                    let name = element.status_name.trim();
                    let newname = name.replace(' ', '_') + '_' + element.id;
                    let th = document.createElement('th');
                    let td = document.createElement('td');
                    th.classList.add('thPayment');
                    td.classList.add('tdPayment');
                    td.id = newname;
                    idArr.push(newname);
                    let localURL = "{{env('APP_URL')}}";
                    th.innerHTML = `

                    
                        <div class="lead_box" style="border-right:10px solid ${element.favcolor} !important;">
   
                                
                                <div class="menu-nav">
        <div class="menu-item">
        <h6 class="mt-1 lead-progress" style="color:${element.favcolor}!important;">${element.status_name}
        <span class="badge badge-light mb-3">${ element.tasks.length }</span></h6>
        </div>
        <div class="dropdown-container" tabindex="-1">
          <div class="three-dots"></div>
          <div class="dropdown">
            <a href="#"><div class="activity-dot">Convert</div></a>
            <a href="#"><div class="activity-dot">Complete</div></a>
            <a href="#"><div class="activity-dot">Progress</div></a>
          </div>
        </div>
      </div>
                               
                          
                        </div>
                        <a href="" data-toggle="modal" data-target="#myModal" onclick="addTask(${element.id},'${element.status_name}')"><p class="mt-3" style="text-align:center;"> + Add ${element.status_name} </p></a>

                        
                    `;
                    let tasks = element.tasks;
                    if (tasks.length > 0) {
                        let indexCount = 0;
                        tasks.forEach(task => {
                            let assignees = task.users;
                            let assigneeToolTip = ``;
                            if (assignees.length == 0) {
                                assigneeToolTip = ` Assignees : ${assignees.length} `;                                
                            } else {
                                assigneeToolTip = ` Assignees : `;

                                assignees.forEach((assignee,index) => {
                                    if (index == 0) {
                                        assigneeToolTip = assigneeToolTip + `${assignee.name}`;
                                    } else {
                                        assigneeToolTip = assigneeToolTip + `, ${assignee.name}`;
                                    }
                                });
                            }
                            indexCount++;
                            let rowDiv = document.createElement('div');
                            let div = document.createElement('div');
                            div.classList.add('lead_box1');
                            // if (lead.is_converted == 1) {
                            //     div.setAttribute('draggable', false);
                            // } else {
                            //     div.setAttribute('draggable', true);
                            // }
                            div.setAttribute('draggable', true);
                            div.setAttribute('ondragstart', 'dragStart()');
                            div.setAttribute('id', `lead_box_${task.id}`);
                            rowDiv.classList.add('row');
                            
                            rowDiv.innerHTML = `
                            
                            
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <a href="/taskprofile/${task.id}">
                                            <h5 class="lead-ti">${ task.name.length >= 30 ? task.name.slice(0,30)+'...' :  task.name}</h5>
                                            <i class="fa fa-user mt-2" data-bs-toggle="tooltip" data-bs-placement="top" title="${assigneeToolTip}"></i>
                                            <span><i class="fa fa-flag text-danger mt-2 ml-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Priority : ${task.priority}"></i></span>
                                        </a>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="menu-nav" style="float:right;">
                                            <div class="dropdown-container" tabindex="-1" style="float:right;">
                                                <div class="three-dots"></div>
                                                <div class="dropdown">
                                                    <a href="#">
                                                        <div class="activity-dot">Cancel</div>
                                                    </a>
                                                    <a href="#">
                                                        <div class="activity-dot">Halt</div>
                                                    </a>
                                                    <a href="#">
                                                        <div class="activity-dot">Add Handler</div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>



                            <div class="d-flex bd-highlight mt-3 p-3">
                                <div class="flex-fill bd-highlight">

                                    <span class="input-group-text"
                                        style="background-color:transparent!important; border:none!important; padding:0px;">
                                        <i class="fa fa-calendar deal"> ${task.deadline.split('T')[0]}</i>
                                </div>
                            </div>

                  
                            `;

                            div.appendChild(rowDiv);
                            td.appendChild(div);
                        });
                    } else {

                    }
                    statusSettingContainerDiv.appendChild(th);
                    leadContainerDiv.appendChild(td);
                });

                idArr.forEach(id => {
                    let box = document.getElementById(id);
                    box.setAttribute('ondrop', "drop('{{ route('ajax.updateTask') }}')");
                    box.setAttribute('ondragover', 'allowDrop()');
                });
            }
        }

    }

    function dragStart() {
        let id = event.target.id;
        event.dataTransfer.setData('text/plain', id);
    }

    async function drop(url) {
        const id = event.dataTransfer.getData('text/plain');
        const draggable = document.getElementById(id);
        event.target.appendChild(draggable);
        let splitId = id.split('_');
        let leadId = splitId[splitId.length - 1];
        let splitStatusId = event.target.id.split('_');
        let statusId = splitStatusId[splitStatusId.length - 1];
        debugger;

        let formData = new FormData();
        formData.append('id', leadId);
        formData.append('status_id', statusId);

        // let url = "{{ route('ajax.updateLead') }}";
        let requestOptions = {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            method: "POST",
            body: formData
        };
        let response = await fetch(url, requestOptions);
        debugger;

        if (response.status == 200) {
            let data = await response.json();
            debugger;

            let selectedOption = document.getElementById('categorySelector').value;
            if (data.response == true) {
                assigneeTogglerObj.viewMe == true ? renderAssignees("{{auth()->id()}}","{{ route('ajax.getAssigneesTask') }}") : renderRespectiveSettings(selectedOption);
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
                renderRespectiveSettings(selectedOption);
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

    function allowDrop() {
        event.preventDefault();
    }

</script>

<script>
    let count = 0;
    let firstClicked = false;
    let lastClicked = false;

    function addRow() {
        count++;
        let div = document.createElement('div');
        let settingDiv = document.getElementById('settingDiv');
        let firstRow = document.createElement('div');
        let lastRow = document.createElement('div');
        let randomColor = '#'+Math.floor(Math.random()*16777215).toString(16);
        firstRow.classList.add('row');
        lastRow.classList.add('row');
        firstRow.innerHTML = `
        <div class="col-md-12">
            <button class="btn btn-success btn-add float-right" onclick="removeRow()"
                style="text-align:center;line-height: 18.15px;font-size:15px;font-weight:400;color:#E46262"
                type="button">
                <i class="fa fa-minus" style="margin: auto" aria-hidden="true"></i>
            </button>
        </div>
        `;
        lastRow.innerHTML = `
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label"
                        style="color:#131540;font-size: 11px;line-height:13.31px;font-weight:700;float:left;">State
                        Name <sup>*</sup></label>
                    <input type="text" class="form-control status_name" placeholder="name" name="status_name[]">

                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-around">
                <div>
                    <label style="color:#131540;font-size: 11px;line-height:13.31px;font-weight:700;float:left;">Hierachy <sup>*</sup> </label>
                    <input type="text" class="form-control heirarchy_order" placeholder="hierarchy" name="heirarchy${count}" id="heirarchy${count}" style="width:100%;">
                </div>
                <div>
                    <div class="input-group-text" style="margin-top:35px;background:white;border:1px solid #eaeaea"><span
                            style="margin-left:8px!important; font-size:10px;font-weight:500;color:#999">Begin</span>
                        <input class="form-check-input mt-0 notclickedf" type="radio" value="First"
                            aria-label="Radio button for following text input"
                            style="margin-left:-6px!important;" name="first_radio${count}" id="first_radio${count}" onclick="toggleRadio(${count})">
                    </div>
                </div>

                <div>
                    <div class="input-group-text" style="margin-top:35px;background:white;border:1px solid #eaeaea"><span
                            style="margin-left:8px!important; font-size:10px;font-weight:500;color:#999">Closed</span>
                        <input class="form-check-input mt-0 notclickedl" type="radio" value="Last"
                            aria-label="Radio button for following text input"
                            style="margin-left:-6px!important;" name="last_radio${count}" id="last_radio${count}" onclick="toggleRadio(${count})">
                    </div>
                </div>
                <div>
                    <div class="input-group-text" style="margin-top:35px;background:white;border:1px solid #eaeaea"><span
                            style="margin-left:8px!important; font-size:10px;font-weight:500;color:#999">None</span>
                        <input class="form-check-input mt-0 notclickedn" type="radio" value=""
                            aria-label="Radio button for following text input"
                            style="margin-left:-6px!important;" name="none_radio${count}" id="none_radio${count}" onclick="toggleRadio(${count})">
                    </div>
                </div>


                <div>
                    <div style="margin-top:35px;">

                        <input type="color" id="favcolor" name="favcolor[]" value="${randomColor}"><br><br>

                    </div>

                </div>
            </div>
        `;
        div.appendChild(firstRow);
        div.appendChild(lastRow);
        settingDiv.appendChild(div);
    }

    function submitStatus() {
        let form = document.getElementById('leadStatusForm');
        let statusNames = document.getElementsByClassName('status_name');
        let statusSettings = document.getElementsByClassName('statusSettings');
        let heirarchyOrders = document.getElementsByClassName('heirarchy_order');
        let entries = [...statusNames, ...statusSettings, ...heirarchyOrders];
        let validateH = validateHeirarchy([...heirarchyOrders]);
        let validationRes = validateStatus(entries);
        if (validationRes == true) {
            if (validateH.response == false) {
                Swal.fire({
                    title: validateH.message,
                    icon: 'error',
                    position: "top-right",
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            } else {
                form.submit();
            }
        }
    }

    function validateHeirarchy(heirarchies) {
        let returnObj = {};
        let shouldBeCount = 2;
        let receivingCount = 0;
        heirarchies.forEach(element => {
            if (element.disabled == true) {
                receivingCount++;
            }
        });
        if (receivingCount === shouldBeCount) {
            returnObj.response = true;
        } else {
            returnObj.response = false;
            returnObj.message = 'Both first and last stages in heirarchy need to be selected';
        }
        return returnObj;
    }

    function validateStatus(entries) {
        let errCount = 0;
        entries.forEach(element => {
            let elClasses = element.classList;
            if (elClasses.contains('status_name')) {
                if (element.value == '') {
                    errCount++;
                    element.style.border = '1px solid red';
                } else {
                    element.style.border = '1px solid #eaeaea';
                }
            } else if (elClasses.contains('statusSettings')) {
                if (element.selectedIndex == 0) {
                    errCount++;
                    element.style.border = '1px solid red';
                } else {
                    element.style.border = '1px solid #eaeaea';
                }
            } else if (elClasses.contains('heirarchy_order')) {
                debugger;
                if (element.disabled == false && element.value == '') {
                    errCount++;
                    element.style.border = '1px solid red';
                } else {
                    element.style.border = '1px solid #eaeaea';
                }
            }
        });
        if (errCount > 0) {
            return false;
        } else {
            return true;
        }
    }

    function removeRow() {
        let eventTarget = event.target;
        if (eventTarget.tagName == 'I') {
            event.target.parentElement.parentElement.parentElement.parentElement.remove();
        } else {
            event.target.parentElement.parentElement.parentElement.remove();
        }
    }

    function toggleRadio(indexNo) {
        let firstRadio = document.getElementById('first_radio' + indexNo);
        let lastRadio = document.getElementById('last_radio' + indexNo);
        let noneRadio = document.getElementById('none_radio' + indexNo);
        let heirarchy = document.getElementById('heirarchy' + indexNo);
        let eventTarget = event.target;
        debugger;
        switch (eventTarget.name) {
            case 'first_radio' + indexNo:
                if (firstClicked == true) {
                    clickedFirstArr = Array.from(document.getElementsByClassName('clickedf'));

                    for (let index = 0; index < clickedFirstArr.length; index++) {
                        if (eventTarget == clickedFirstArr[index]) {
                            break;
                        } else {
                            let id = clickedFirstArr[index].id.replace('first_radio', '');
                            clickedFirstArr[index].classList.replace('clickedf', 'notclickedf');
                            clickedFirstArr[index].checked = false;
                            document.getElementById('heirarchy' + id).disabled = false;
                        }
                    }
                    firstRadio.classList.replace('notclickedf', 'clickedf');
                    if (lastRadio.checked == true) {
                        lastRadio.checked = false;
                    }
                    if (noneRadio.checked == true) {
                        noneRadio.checked = false;
                    }
                } else {
                    firstClicked = true;
                    if (lastRadio.checked == true) {
                        lastRadio.checked = false;
                    }
                    if (noneRadio.checked == true) {
                        noneRadio.checked = false;
                    }
                    firstRadio.classList.replace('notclickedf', 'clickedf');
                }
                heirarchy.disabled = true;
                break;
            case 'last_radio' + indexNo:
                if (lastClicked == true) {
                    clickedLastArr = Array.from(document.getElementsByClassName('clickedl'));
                    for (let index = 0; index < clickedLastArr.length; index++) {
                        if (eventTarget == clickedLastArr[index]) {
                            break;
                        } else {
                            let id = clickedLastArr[index].id.replace('last_radio', '');
                            clickedLastArr[index].classList.replace('clickedl', 'notclickedl');
                            clickedLastArr[index].checked = false;
                            document.getElementById('heirarchy' + id).disabled = false;
                        }
                    }
                    lastRadio.classList.replace('notclickedl', 'clickedl');
                    if (firstRadio.checked == true) {
                        firstRadio.checked = false;
                    }
                    if (noneRadio.checked == true) {
                        noneRadio.checked = false;
                    }
                } else {
                    lastClicked = true;
                    if (firstRadio.checked == true) {
                        firstRadio.checked = false;
                    }
                    if (noneRadio.checked == true) {
                        noneRadio.checked = false;
                    }
                    lastRadio.classList.replace('notclickedl', 'clickedl');
                }
                heirarchy.disabled = true;
                break;
            case 'none_radio' + indexNo:
                lastRadio.checked = false;
                firstRadio.checked = false;
                heirarchy.disabled = false;
                break;
            default:
                break;
        }
    }

    // Submitting category
    async function submitCategory() {
        let form = document.getElementById('categoryFormStat');
        let formData = new FormData(form);
        debugger;
        let categoryModal = document.getElementById('second-modal');
        let url = "{{ route('ajax.storeStatusSetting') }}";
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
            debugger;
            if (data.response == true) {
                Swal.fire(
                    'Success', data.message, 'success'
                );
                let selectDiv = document.getElementById('statusSettings');
                debugger;
                let optionsData = data.data;
                let opDiv = document.createElement('option');
                opDiv.value = optionsData.id;
                opDiv.text = optionsData.name;
                opDiv.selected = true;
                selectDiv.add(opDiv);
                debugger;
                $("#second-modal").modal('hide');
                $("#first-modal").modal('show');

            } else {

            }
        }
        debugger;
    }

    var within_first_modal = false;
    $('.btn-second-modal').on('click', function () {
        debugger;
        if ($(this).hasClass('within-first-modal')) {
            within_first_modal = true;
            $('#first-modal').modal('hide');
        }
        $('#second-modal').modal('show');
    });

    $('.btn-second-modal-close').on('click', function () {
        $('#second-modal').modal('hide');
        if (within_first_modal) {
            $('#first-modal').modal('show');
            within_first_modal = false;
        }
    });

    $('.btn-toggle-fade').on('click', function () {
        if ($('.modal').hasClass('fade')) {
            $('.modal').removeClass('fade');
            $(this).removeClass('btn-success');
        } else {
            $('.modal').addClass('fade');
            $(this).addClass('btn-success');
        }
    });

</script>
@endsection
