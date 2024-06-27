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

<div class="d-flex bd-highlight mb-3">

    <div class="mr-auto bd-highlight">
        <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#first-modal">
            <i class="fa fa-plus" aria-hidden="true"></i> Add Status
        </button>
        <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#dynamicModal"
            onclick="addLeadDynamic()">
            <i class="fa fa-plus" aria-hidden="true"></i> Add Lead
        </button>
        <select name="status" class="form-control" id="categorySelector" onchange="renderRespectiveSettings()">
            @forelse($categories as $category)
                <option value="{{ $category->id }}">{{ $category['name'] }}</option>
            @empty

            @endforelse
        </select>
    </div>
    <div class=" p-2 bd-highlight"> <button type="button" class="btn btn-primary convert">Today <i
                class="fa fa-angle-down"></i></button></div>
    <div class="p-2 bd-highlight"> <button type="button" class="btn btn-primary lead">Archive</button></div>
    <div class="p-2 bd-highlight"> <button type="button" class="btn btn-primary convert">Download <i
                class="fa fa-arrow-down" aria-hidden="true"></i></button></div>
</div>



<div class="row">
    <!-- <h6>Status</h6>
    <button type="button" class="btn btn-primary lead" data-toggle="modal" data-target="#myModal">
        + Add Lead
    </button> -->


    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content p-3" style="border-radius:25px;">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Add New Lead</h5>
                    <!-- <p>Add Lead to your contact</p> -->

                    <button type="button" class="close" data-dismiss="modal" onclick="refreshLeadModal('firstForm')">&times;</button>
                </div>

                <!-- Modal body -->
                <form action="" id="firstForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="lead[title]" class="form-control lead1Data">
                                </div>
                            </div>

                                                        
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Organization</label>

                                    <select name="lead[organization_id]" class="form-control lead1Data"
                                        onchange="createOrg('old')" id="organDiv1">
                                        <option value="default" selected>Default</option>
                                        <option value="createOrg">Create New</option>
                                        @foreach($organizations as $org)
                                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Contacts</label>

                                    <select name="lead[contact_id]" id="contactsDiv1" class="form-control lead1Data"
                                        onchange="createContact('old')">
                                        <option value="default" selected>Default</option>
                                        <option value="createContact">Create New</option>
                                        @foreach($contacts as $con)
                                            <option value="{{ $con->id }}">{{ $con->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12" id="createOrg1" hidden>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Organization Name</label>
                                        <input type="text" name="organization[name]" class="form-control organ1Data">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="org_email1">
                                            <label class="form-label">Email <span class="text-danger"
                                                    onclick="addOrganizationFields('organization[email][]','email','org_email1')"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                                            <input type="email" class="form-control org_email organ1Data"
                                                name="organization[email][]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="org_address1">
                                            <label class="form-label">Address <span class="text-danger"
                                                    onclick="addOrganizationFields('organization[address][]','text','org_address1')"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                                            <input type="text" class="form-control org_address organ1Data"
                                                name="organization[address][]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="org_number1">
                                            <label class="form-label">Contact Number <span class="text-danger"
                                                    onclick="addOrganizationFields('organization[number][]','number','org_number1')"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                                            <input type="number" class="form-control org_number organ1Data"
                                                name="organization[number][]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Contact Name</label>
                                            <input type="text" class="form-control organ1Data" name="organization[contact][name]">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- for contact  --}}
                            <div class="col-md-12" id="createContact1" hidden>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" id="contact_person1">
                                            <label class="form-label">Contact Person</label>
                                            <input type="text" id="contactPersonName1" class="form-control contact_person1 contact1Data"
                                                name="contact[name]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="contact_email1">
                                            <label class="form-label">Contact Person Email<span class="text-danger"
                                                    onclick="addOrganizationFields('contact[email][]','text','contact_email1')"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                                            <input type="text" id="contactPersonEmail1" class="form-control contact_email1 contact1Data"
                                                name="contact[email][]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="contact_person_number1">
                                            <label class="form-label">Contact Person Number<span class="text-danger"
                                                    onclick="addOrganizationFields('contact[phone_number][]','text','contact_person_number1')"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                                            <input type="text" id="contactPersonNumber" class="form-control contact_person_number1 contact1Data"
                                                name="contact[phone_number][]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="deal_type1">
                                            <label class="form-label">Select lifecycle stage</label>
                                            <select name="contact[deal_type]" id="" class="form-control contact1Data">
                                                <option value="Customer">Customer</option>
                                                <option value="Lead">Lead</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end contact  --}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="lead[status_id]" id="status_id" value="" hidden>
                                    <label class="form-label">Status Type</label>
                                    <input type="text" class="form-control" name="status_id" value="" id="status_val"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Estimated Worth</label>
                                <input type="text" name="lead[estimated_worth]" class="form-control lead1Data">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Expected Closure Date</label>
                                <input type="date" name="lead[expected_closure_date]" class="form-control lead1Data">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Priority Level</label>
                                <select name="lead[priority_level]" class="form-control lead1Data">
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Additional Description</label>
                                    <textarea name="lead[additional_description]" class="form-control lead1Data" cols="30"
                                        rows="10"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="flex mt-5 mb-3 me-auto">

                        <button type="button" class="btn btn-primary convert" data-toggle="modal" data-target="#myModal"
                            style="width:45%;" onclick="refreshLeadModal('firstForm')">Cancel</button>
                        <button type="button"
                            onclick="storeLead('{{ route('lead.store') }}','firstForm')"
                            class="btn btn-primary save"
                            style="width:45%;">Save</button>
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
                    <h5 class="modal-title">Add New Lead</h5>
                    <!-- <p>Add Lead to your contact</p> -->

                    <button id="closeLeadModal" type="button" class="close" data-dismiss="modal" onclick="refreshLeadModal('secondForm')">&times;</button>
                </div>

                <!-- Modal body -->
                <form action="" id="secondForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="lead[title]" class="form-control leadData">
                                </div>
                            </div>

                            <!-- toggle -->
                            
                        
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Organization</label>


                                    <select name="lead[organization_id]" class="form-control leadData"
                                        onchange="createOrg('new')" id="organDiv">
                                        <option value="default" selected>Default</option>
                                        <option value="createOrg">Create New</option>
                                        @foreach($organizations as $org)
                                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="form-label">Contacts</label>

                                    <select name="lead[contact_id]" id="contactsDiv" class="form-control leadData"
                                        onchange="createContact('new')">
                                        <option value="default" selected >Default</option>
                                        <option value="createContact">Create New</option>
                                        @foreach($contacts as $con)
                                            <option value="{{ $con->id }}">{{ $con->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12" id="createOrg" hidden>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Organization Name</label>
                                        <input type="text" name="organization[name]" class="form-control organData">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="org_email">
                                            <label class="form-label">Email <span class="text-danger"
                                                    onclick="addOrganizationFields('organization[email][]','email','org_email')"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                                            <input type="email" class="form-control org_email organData" name="organization[email][]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="org_address">
                                            <label class="form-label">Address <span class="text-danger"
                                                    onclick="addOrganizationFields('organization[address][]','text','org_address')"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                                            <input type="text" class="form-control org_address organData"
                                                name="organization[address][]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="org_number">
                                            <label class="form-label">Contact Number <span class="text-danger"
                                                    onclick="addOrganizationFields('organization[number][]','number','org_number')"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                                            <input type="number" class="form-control org_number organData"
                                                name="organization[number][]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Contact Name</label>
                                            <input type="text" class="form-control organData" name="organization[contact][name]">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" id="createContact" hidden>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" id="contact_person">
                                            <label class="form-label">Contact Person</label>
                                            <input type="text" id="contactPersonName" class="form-control contact_person contactData"
                                                name="contact[name]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="contact_email">
                                            <label class="form-label">Contact Person Email<span class="text-danger"
                                                    onclick="addOrganizationFields('contact[email][]','text','contact_email')"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                                            <input type="text" id="contactPersonEmail" class="form-control contact_email contactData"
                                                name="contact[email][]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="contact_person_number">
                                            <label class="form-label">Contact Person Number<span class="text-danger"
                                                    onclick="addOrganizationFields('contact[phone_number][]','text','contact_person_number')"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></span></label>
                                            <input type="text" id="contactPersonNumber" class="form-control contact_person_number contactData"
                                                name="contact[phone_number][]">
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group" id="deal_type">
                                            <label class="form-label">Select lifecycle stage</label>
                                            <select name="contact[deal_type]" id="" class="form-control contactData">
                                                <option value="Customer">Customer</option>
                                                <option value="Lead">Lead</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="col-md-6" id="dynamicDiv">
                                    
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Estimated Worth</label>
                                <input type="text" name="lead[estimated_worth]" class="form-control leadData">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Expected Closure Date</label>
                                <input type="date" name="lead[expected_closure_date]" class="form-control leadData">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Priority Level</label>
                                <select name="lead[priority_level]" class="form-control leadData">
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Additional Description</label>
                                    <textarea name="lead[additional_description]" class="form-control leadData" cols="30"
                                        rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="flex mt-5 mb-3 me-auto">

                        <button type="button" class="btn btn-primary convert" data-toggle="modal"
                            data-target="#dynamicModal" style="width:45%;" onclick="refreshLeadModal('secondForm')">Cancel</button>
                        <button type="button"
                            onclick="storeLead('{{ route('lead.store') }}','secondForm')"
                            class="btn btn-primary save" 
                            style="width:45%;">Save</button>
                    </div>

                    <p class="mt-2 text-danger" id="leadFormError"></p>
                </form>

            </div>

            </div>
        </div>

        <!-- Modal footer -->

    </div>
</div>
</div>

<table class="paymentTable" id="dragTable">

    <tr id="statusSettingContainerDiv">



    </tr>



    <tr id="leadContainerDiv">
        
   
        {{-- <td class="tdPayment" id="current">
            <div class="lead_box1">
                <div class="row">
                    <div class="col-md-4">
                        <a href=""> <img src="backend/images/avatar-1.jpg" id="imageDiv"
                                class="img-fluid customImage current_lead" alt=""
                                style="border-radius:50%;height:60px;border:3px solid #4046DD!important;"></a></div>
                    <div class="col-md-8 mt-1"><i class="fa fa-ellipsis-h" aria-hidden="true" style="float:right;"></i>
                        <h6 class="current_lead">Current</h6>
                        Email@gmail.com
                    </div>

                </div>
            </div>



        </td>

        <td class="tdPayment" id="progress">
            <div class="lead_box1">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('lead.leadprogress') }}"> <img
            src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage" alt=""
            style="border-radius:50%;height:60px; border:3px solid #2C814E!important;"></a></div>
        <div class="col-md-8 mt-1"><i class="fa fa-ellipsis-h" aria-hidden="true" style="float:right;"></i>
            <h6 class="current_lead">Progress</h6>
            Email@gmail.com
        </div>

        </div>
        </div>


        </td>


        <td class="tdPayment" id="owes">
            <div class="lead_box1">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('lead.leadqualified') }}"> <img
                                src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage" alt=""
                                style="border-radius:50%;height:60px; border:3px solid #4DB5D6!important;"></a></div>
                    <div class="col-md-8 mt-1"><i class="fa fa-ellipsis-h" aria-hidden="true" style="float:right;"></i>
                        <h6 class="current_lead">Qualified</h6>
                        Email@gmail.com
                    </div>

                </div>
            </div>


        </td>

        <td class="tdPayment" id="proposal">
            <div class="lead_box1">
                <div class="row">
                    <div class="col-md-4">
                        <a href="#"> <img src="backend/images/avatar-1.jpg" id="imageDiv" class="img-fluid customImage"
                                alt="" style="border-radius:50%;height:60px; border:3px solid #E46262!important;"></a>
                    </div>
                    <div class="col-md-8 mt-1"><i class="fa fa-ellipsis-h" aria-hidden="true" style="float:right;"></i>
                        <h6 class="current_lead">Full Name Here</h6>
                        Email@gmail.com
                    </div>

                </div>
            </div>


        </td>

        <td class="tdPayment" id="halt">
            <div class="lead_box1">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('lead.leadhalt') }}"> <img src="backend/images/avatar-1.jpg"
                                id="imageDiv" class="img-fluid customImage" alt=""
                                style="border-radius:50%;height:60px; border:3px solid  #4DB5D6!important;"></a></div>
                    <div class="col-md-8 mt-1"><i class="fa fa-ellipsis-h" aria-hidden="true" style="float:right;"></i>
                        <h6 class="current_lead">Halt</h6>
                        Email@gmail.com
                    </div>

                </div>
            </div>


        </td> --}}
    </tr>
</table>




<!-- Add statu section -->
<!-- Modal -->
<div class="container text-center">




    <div class="modal" id="first-modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog model-lg">
            <div class="modal-content" style="border-radius:8px;box-shadow: 6px 4px 42px -4px rgba(66, 71, 200, 0.53);">
                <div class="modal-header d-flex justify-content-between align-items-start">

                    <div>
                        <h5 class="modal-title"
                            style="font-size: 16px;color:#131540;line-height:19.36px;font-weight:700" id="myModalLabel">
                            Add New Status<br>
                            <p class="catagories ml-4 mt-2" style="font-size: 12px;color:#ACACAC">Add new status to the
                                lead</p>
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
                                        style="color:#131540;font-size: 11px;line-height:13.31px;font-weight:700;float:left;">Status
                                        Catagories <sup>*</sup></label>
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
                                        + Catagories
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
                        <input type="text" name="module" value="lead" hidden>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let categoryId = null;
    let categoryName = '';
    let localURL = "{{env('APP_URL')}}";

    let idArr = [];
    window.addEventListener('load', () => {
        let jsonData = @json($categories, JSON_PRETTY_PRINT);
        if (jsonData.length > 0) {
            renderRespectiveSettings(jsonData[0].id);
        }

        let tdClassDiv = document.getElementsByClassName('tdPayment');

    });

    

    async function addLeadDynamic() {
        let url = "{{ route('ajax.getLeadStatus','something') }}";
        let newUrl = url.replace('something', categoryId);
        debugger ;
        let response = await fetch(newUrl);
        if (response.status == 200) {
            let data = await response.json();
            if (data.response == true) {
                let dynamicDiv = document.getElementById('dynamicDiv');
                dynamicDiv.innerHTML = data.page;
            } else {
                alert(data.message);
            }
            debugger ;
        }
    }

    function validateLeadForm(formId) {
        let leadsData = formId == 'secondForm' ? Array.from(document.getElementsByClassName('leadData')) : Array.from(document.getElementsByClassName('lead1Data'));
        let errCount = 0;
        isDefault = false;
        
        leadsData.forEach(element => {
            if (element.name == 'lead[organization_id]') {
                if (element.value == 'default') {
                    isDefault = true;
                    element.style.border = '1px solid red';
                    errCount++;
                }else if (element.value == 'createOrg') {
                    isDefault = false;
                    let organizationData = formId == 'secondForm' ? Array.from(document.getElementsByClassName('organData')) : Array.from(document.getElementsByClassName('organ1Data'));
                    organizationData.forEach(orgData => {
                        if (orgData.value == '') {
                            orgData.style.border = '1px solid red';
                            errCount++;
                        } else {
                            orgData.style.border = '1px solid #eaeaea';
                        }
                    });
                } else {
                    element.style.border = '1px solid #eaeaea';
                }
            }else if (element.name == 'lead[contact_id]') {
                
                if (element.value == 'default') {
                    if (isDefault) {
                        element.style.border = '1px solid red';
                        errCount++;
                    }
                }else if (element.value == 'createContact') {
                    if (isDefault) {
                        errCount--;
                    }
                    let contactData = formId == 'secondForm' ? Array.from(document.getElementsByClassName('contactData')) : Array.from(document.getElementsByClassName('contact1Data'));
                    if (isDefault) {
                        errCount--;
                    }
                    contactData.forEach(conData => {
                        if (conData.value == '') {
                            conData.style.border = '1px solid red';
                            errCount++;
                        } else {
                            conData.style.border = '1px solid #eaeaea';
                        }
                    });
                } else {
                    if (isDefault == true) {
                        errCount--;
                    }
                    element.style.border = '1px solid #eaeaea';
                    debugger ;
                }
            } else {
                if (element.name == 'lead[additional_description]') {
                    element.style.border = '1px solid #eaeaea';
                } else {
                    if (element.value == '') {
                        element.style.border = '1px solid red';
                        errCount++;
                    } else {
                        element.style.border = '1px solid #eaeaea';
                    }
                }
                
            }
        });
        if (errCount > 0) {
            return false;
        } else {
            return true;
        }
    }

    async function storeLead(url, formId) {
        let form = document.getElementById(formId);
        let formData = new FormData(form);
        let errorDiv = formId == 'secondForm' ? document.getElementById('leadFormError') : document.getElementById('leadFormError1');

        validationResponse = validateLeadForm(formId);
        if (validationResponse == true) {
            let requestOptions = {
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                method: "POST",
                body: formData
            };
            let response = await fetch(url, requestOptions);
            if (response.status == 200) {
                debugger ;

                let data = await response.json();
                if (data.response == true) {
                debugger ;

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
                    $('#closeLeadModal').click();
                    $('.modal-backdrop').remove();


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
                debugger ;
                errorDiv.textContent = '';
            }
        }else{
            debugger ;
            errorDiv.textContent = 'Please fill the fields';
        }
    }

    function addLead(id, name) {
        let statusType = document.getElementById('status_val');
        let statusId = document.getElementById('status_id');
        statusType.value = name;
        statusId.value = id;
    }

    function refreshLeadModal(type) {
        let leadsData = type == 'secondForm' ? Array.from(document.getElementsByClassName('leadData')) : Array.from(document.getElementsByClassName('lead1Data'));
        let organizationData = type == 'secondForm' ? Array.from(document.getElementsByClassName('organData')) : Array.from(document.getElementsByClassName('organ1Data'));
        let contactData = type == 'secondForm' ? Array.from(document.getElementsByClassName('contactData')) : Array.from(document.getElementsByClassName('contact1Data'));
        let organDiv = type == 'secondForm' ? document.getElementById('createOrg') : document.getElementById('createOrg1');
        let contactDiv = type == 'secondForm' ? document.getElementById('createContact') : document.getElementById('createContact1');
        let contactSectionID = type == 'secondForm' ? 'contactsDiv' : 'contactsDiv1';
        let entries = [...leadsData,...organizationData,...contactData];
        debugger ;
        entries.forEach(element => {
            if (element.tagName == 'SELECT') {
                if (element.id == contactSectionID) {
                    let url = "{{ route('ajax.getContacts','something') }}";
                    let newUrl = url.replace('something', 'default');
                    renderRespectiveContacts(newUrl, document.getElementById(contactSectionID));            
                } else {
                    element.value = element.options[0].value;
                }
                element.hidden = false;
                organDiv.hidden = true;
                contactDiv.hidden = true;
            } else {
                element.value = '';
            }
            element.style.border = '1px solid #eaeaea';
        });
        
        debugger ;

        let errorDiv = type == 'secondForm' ? document.getElementById('leadFormError') : document.getElementById('leadFormError1');
        errorDiv.textContent = '';
        

    }

    function createContact(type) {
        let elementDiv = type == 'new' ? document.getElementById("createOrg") : document.getElementById("createOrg1");
        let contactDiv = type == 'new' ? document.getElementById('contactsDiv') : document.getElementById('contactsDiv1');
        let contactDiv1 = type == 'new' ? document.getElementById('createContact') : document.getElementById('createContact1');
        let organDiv = type == 'new' ? document.getElementById('organDiv') : document.getElementById('organDiv1');
        let selectedVal = event.target.value;
        debugger ;
        if (selectedVal == 'createContact') {
            elementDiv.hidden = true;
            contactDiv1.hidden=false;
            organDiv.hidden = true;
        } else {
            if (selectedVal == 'default') {
                organDiv.hidden = false;
            }else{
                organDiv.hidden = true;

            }
            contactDiv1.hidden = true;
        }
        
    }

    function createOrg(type) {
        let elementDiv = type == 'new' ? document.getElementById("createOrg") : document.getElementById("createOrg1");
        let contactDiv = type == 'new' ? document.getElementById('contactsDiv') : document.getElementById('contactsDiv1');

        let selectedVal = event.target.value;
        if (selectedVal == "createOrg") {
            elementDiv.hidden = false;
            contactDiv.hidden = true;
        }else {

            elementDiv.hidden = true;
            contactDiv.hidden = false;
            let url = "{{ route('ajax.getContacts','something') }}";
            let newUrl = url.replace('something', selectedVal);
            renderRespectiveContacts(newUrl, contactDiv);
            debugger ;
        }
    }

    async function renderRespectiveContacts(url, contactDiv) {
        let response = await fetch(url);
        if (response.status == 200) {
            let data = await response.json();
            debugger ;
            if (data.response == true) {
                let selectContactDiv = contactDiv;
                if (selectContactDiv.childElementCount > 0) {
                    selectContactDiv.innerHTML = ``;
                }
                selectContactDiv.innerHTML = data.page;
            }
        }
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
        let url = "{{ route('ajax.getStatusSetting','something') }}";
        let newUrl = url.replace("something", categoryId);
        let response = await fetch(newUrl);
        debugger ;
        if (response.status == 200) {
            let data = await response.json();
            debugger ;
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
                    th.innerHTML = `

                    
                        <div class="lead_box" style="border-right:10px solid ${element.favcolor} !important;">
   
                                
                                <div class="menu-nav">
        <div class="menu-item">
        <h6 class="mt-1 lead-progress" style="color:${element.favcolor}!important;">${element.status_name}
        <span class="badge badge-light mb-3">${ element.leads.length }</span></h6>
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
                        <a href="" data-toggle="modal" data-target="#myModal" onclick="addLead(${element.id},'${element.status_name}')"><p class="mt-3" style="text-align:center;"> + Add ${element.status_name} </p></a>

                        
                    `;
                    let leads = element.leads;
                    if (leads.length > 0) {
                        let indexCount = 0;
                        leads.forEach(lead => {
                            indexCount++;
                            let rowDiv = document.createElement('div');
                            let div = document.createElement('div');
                            div.classList.add('lead_box1');
                            if (lead.is_converted == 1) {
                                div.setAttribute('draggable', false);
                            } else {
                                div.setAttribute('draggable', true);
                            }
                            div.setAttribute('ondragstart', 'dragStart()');
                            div.setAttribute('id', `lead_box_${lead.id}`);
                            rowDiv.classList.add('row');
                            rowDiv.innerHTML = `

                            
                            <div class="col-md-12">

                              <div class="row">

                              
                        <div class="col-lg-6 col-md-6">
                                <a href="/leadprofile/${lead.id}"> 
                                <h6 class="current_lead"> ${lead.relation.organization!=null ? (lead.relation.organization.name.length>15? lead.relation.organization.name.substr(0,15)+'...|':lead.relation.organization.name+'|'):''}  ${lead.relation.contact!=null? (lead.relation.contact.name.length>15? lead.relation.contact.name.substr(0,15)+"...": lead.relation.contact.name):'' }</h6>
                                <h5 class="lead-ti">${ lead.title }</h5>
                                
                               
           
                                </a>
                            </div>
                           
                              <div class="col-md-6">
                            <div class="menu-nav"  style="float:right;">
      
        <div class="dropdown-container" tabindex="-1" style="float:right;">
          <div class="three-dots"></div>
          <div class="dropdown">
            ${lead.is_converted!=1?`<div  onclick="convertDeal('${localURL}',${lead.id})"><div class="activity-dot">Convert</div></div>`:''}
            <a href="#"><div class="activity-dot">Cancel</div></a>
            <a href="#"><div class="activity-dot">Halt</div></a>
            <a href="#"><div class="activity-dot">Add Handler</div></a>
          </div>
        </div>
      </div>
                               
                          
                        </div>
                        </div>

                        </div>
                                
                                </div>


                                <div class="d-flex bd-highlight mt-3 p-3">
                              <div class="flex-fill bd-highlight" >

                                <span class="input-group-text" style="background-color:transparent!important; border:none!important; padding:0px;">
                                <i class="fa fa-calendar deal"> ${lead.created_at.split('T')[0]}</i>
    </div>
  <div class="flex-fill bd-highlight align-self-center"><span class="card-link lead">${ lead.is_converted == 0 ? 'lead' :'Customer' }</span></div>
 
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
                    box.setAttribute('ondrop', 'drop()');
                    box.setAttribute('ondragover', 'allowDrop()');
                });
            }
        }
    }
    // $(function () {
    //     debugger ;
    //     $(idArr.toString()).sortable({
    //         connectWith: ".tdPayment",
    //         remove: function (e, ui) {
    //             var $this = $(this);
    //             var childs = $this.find('div');
    //             if (childs.length === 0) {
    //                 $this.text("Nothing");
    //             }
    //         },
    //         receive: function (e, ui) {
    //             debugger ;
    //             $(this).contents().filter(function () {
    //                 return this.nodeType == 3; //Node.TEXT_NODE
    //             }).remove();
    //         },
    //     }).disableSelection();
    // });
    async function convertDeal(localUrl,id){
        // let url = localUrl+"/lead-convert/"+id;
        let url="{{ route('lead.convert',':id') }}"
        url=url.replace(':id',id);
        let response = await fetch(url);
        debugger 
        if (response.status == 200) {
            let data = await response.json();
            debugger 
            let selectedOption = document.getElementById('categorySelector').value;
            if (data.response == true) {
                renderRespectiveSettings(selectedOption);
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
            debugger ;
        }
        debugger ;
    }

    function dragStart() {
        let id = event.target.id;
        event.dataTransfer.setData('text/plain', id);
    }

    /* drop targets */


    async function drop() {
        const id = event.dataTransfer.getData('text/plain');
        const draggable = document.getElementById(id);
        event.target.appendChild(draggable);
        let splitId = id.split('_');
        let leadId = splitId[splitId.length - 1];
        let splitStatusId = event.target.id.split('_');
        let statusId = splitStatusId[splitStatusId.length - 1];

        let formData = new FormData();
        formData.append('lead_id', leadId);
        formData.append('status_id', statusId);

        let url = "{{ route('ajax.updateLead') }}";
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
            let selectedOption = document.getElementById('categorySelector').value;
            if (data.response == true) {
                renderRespectiveSettings(selectedOption);
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
        debugger ;
    }

    function allowDrop() {
        event.preventDefault();
    }

</script>

<script>
    let count = 0;
    let firstClicked = false;
    let lastClicked = false;



    async function submitCategory() {
        let form = document.getElementById('categoryFormStat');
        let formData = new FormData(form);
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
            debugger ;
            if (data.response == true) {
                Swal.fire(
                    'Success', data.message, 'success'
                );
                let selectDiv = document.getElementById('statusSettings');
                debugger ;
                let optionsData = data.data;
                let opDiv = document.createElement('option');
                opDiv.value = optionsData.id;
                opDiv.text = optionsData.name;
                opDiv.selected = true;
                selectDiv.add(opDiv);
                debugger ;
                $("#second-modal").modal('hide');
                $("#first-modal").modal('show');

            } else {

            }
        }
        debugger ;
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

    function validateHeirarchy(heirarchies){
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
                debugger ;
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

    function toggleRadio(indexNo) {
        let firstRadio = document.getElementById('first_radio' + indexNo);
        let lastRadio = document.getElementById('last_radio' + indexNo);
        let noneRadio = document.getElementById('none_radio' + indexNo);
        let heirarchy = document.getElementById('heirarchy' + indexNo);
        let eventTarget = event.target;
        debugger ;
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

    function addRow() {
        count++;
        let div = document.createElement('div');
        let settingDiv = document.getElementById('settingDiv');
        let firstRow = document.createElement('div');
        let lastRow = document.createElement('div');
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

                        <input type="color" id="favcolor" name="favcolor[]" value="#E46262"><br><br>

                    </div>

                </div>
            </div>
        `;
        div.appendChild(firstRow);
        div.appendChild(lastRow);
        settingDiv.appendChild(div);
    }

    function removeRow() {
        let eventTarget = event.target;
        if (eventTarget.tagName == 'I') {
            event.target.parentElement.parentElement.parentElement.parentElement.remove();
        } else {
            event.target.parentElement.parentElement.parentElement.remove();
        }
    }

    var within_first_modal = false;
    $('.btn-second-modal').on('click', function () {
        debugger ;
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

{{-- <script>
    $(function () {
        $(document).on('click', '.btn-add', function (e) {
            e.preventDefault();

            var dynaForm = $('.dynamic-wrap form:first'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo(dynaForm);
            debugger ;

            newEntry.find('input').val('');
            dynaForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span> <i class="fa fa-minus" aria-hidden="true"></i> </span>');
        }).on('click', '.btn-remove', function (e) {
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
        });
    });

</script> --}}


<script>
    var dribbble404 = {
        collage: document.querySelector(".collage-404"),
        collageImages: document.querySelector(".collage-404-images"),
        collageH1: document.querySelector(".collage-404 h1"),
        html: document.documentElement,
        colorRange: document.querySelector(".color-range"),
        colorChoice: document.getElementById("color-choice"),
        currentRange: 0,
        shots: [],
        utils: {
            hsl2Rgb: function (h, s, l) {
                s = s / 100;
                l = l / 100;
                var c, x, m, rgb;
                c = (1 - Math.abs(2 * l - 1)) * s;
                x = c * (1 - Math.abs(((h / 60) % 2) - 1));
                m = l - c / 2;
                if (h >= 0 && h < 60) rgb = [c, x, 0];
                if (h >= 60 && h < 120) rgb = [x, c, 0];
                if (h >= 120 && h < 180) rgb = [0, c, x];
                if (h >= 180 && h < 240) rgb = [0, x, c];
                if (h >= 240 && h < 300) rgb = [x, 0, c];
                if (h >= 300 && h <= 360) rgb = [c, 0, x];

                return rgb.map(function (v) {
                    return (255 * (v + m)) | 0;
                });
            },
            rgb2Hex: function (r, g, b) {
                var rgb = b | (g << 8) | (r << 16);
                return "#" + (0x1000000 + rgb).toString(16).slice(1);
            },
            hsl2Hex: function (h, s, l) {
                var rgb = this.hsl2Rgb(h, s, l);
                return this.rgb2Hex(rgb[0], rgb[1], rgb[2]);
            },
            hueFromRangeValue: function (val) {
                return ((val / 100) * 360).toFixed(0);
            },
            inputSupported: function (type) {
                var x = document.createElement("input");
                x.setAttribute("type", type);
                return x.type === type;
            },
            listenForKeyCombo: function (combo, callback) {
                if (window.addEventListener) {
                    var keys = [];
                    var konami = window.addEventListener(
                        "keydown",
                        function (e) {
                            keys.push(e.keyCode);
                            if (keys.toString().indexOf(combo) >= 0) {
                                keys = [];
                                callback();
                            }
                        }.bind(this),
                        true
                    );
                }
            }
        },
        init: function () {
            this.currentRange = Math.floor(100 * Math.random());

            if (this.colorRange && this.utils.inputSupported("range")) {
                this.colorRange.addEventListener(
                    "change",
                    this.fetchAndBuildShots.bind(this)
                );
                this.colorRange.addEventListener("input", this.syncColors.bind(this));
                this.colorRange.value = this.currentRange;
                var event = new Event("change");
                this.colorRange.dispatchEvent(event);
            } else {
                this.colorRange.style.display = "none";
                this.fetchAndBuildShots();
            }

            this.utils.listenForKeyCombo(
                "38,38,40,40,37,39,37,39,66,65",
                this.konami.bind(this)
            );
        },
        loading: function () {
            this.html.classList.remove("loaded");
            this.html.classList.add("loading");
        },
        loaded: function () {
            this.html.classList.remove("loading");
            this.html.classList.add("loaded");
        },
        konami: function () {
            this.collageH1.innerHTML =
                '<svg width="176" height="128" viewBox="0 0 176 128" fill="black" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M48 0H32V16H48V32H32V48H16V64H0V112H16V80H32V112H48V128H80V112H48V96H128V112H96V128H128V112H144V80H160V112H176V64H160V48H144V32H128V16H144V0H128V16H112V32H64V16H48V0ZM48 64V48H64V64H48ZM128 48H112V64H128V48Z"/></svg>';
            this.collage.classList.add("arkanoid");
            this.loading();
            this.build404Shots(this.shots);
        },
        build404Shots: function (data) {
            this.collageImages.innerHTML = "";
            var numLoaded = 0;
            var that = this;

            //create all links to shots and images
            Array.prototype.forEach.call(data, function (shot, i) {
                if (i > 51) return;

                var link = document.createElement("a");
                link.href = shot.url;

                //randomly position and style each shot link
                var x = 0 * Math.random();
                var y = 0 * Math.random();
                var z = 500 * Math.random();
                var s = 0.75 + 0.25 * Math.random();
                var transform =
                    "translateX(" + x + "%) translateY(" + y + "%) scale(" + s + ") ";
                link.style.transform = transform + " translateZ(" + z + "px)";
                link.style.color = "rgba(0,0,0," + (1 - s) * 0.5 + ")";
                link.style.boxShadow = "0 0 0 currentColor";

                //setup the shot image
                var img = document.createElement("img");

                function imgLoaded() {
                    numLoaded++;
                    link.classList.add("loaded");
                    link.style.transform = transform;
                    setTimeout(function () {
                        link.classList.add("introduced");
                    }, 2000);
                    if (numLoaded == data.length) {
                        that.loaded();
                    }
                }

                //start loading the image
                img.src = shot.img;
                if (img.complete) {
                    setTimeout(imgLoaded, 10);
                } else {
                    img.addEventListener("load", imgLoaded);
                    img.addEventListener("error", imgLoaded);
                }

                // append all to the 404 images
                link.appendChild(img);
                that.collageImages.appendChild(link);
            });
        },
        syncColors: function () {
            var hue = this.utils.hueFromRangeValue(this.currentRange);
            if (this.utils.inputSupported("range")) {
                hue = this.utils.hueFromRangeValue(this.colorRange.value);
            }
            var hsl = "hsl(" + hue + ", 100%, 50%)";
            var hex = this.utils.hsl2Hex(hue, 100, 50);
            this.colorRange.style.color = hsl;
            this.colorChoice.style.color = hsl;
            this.colorChoice.innerHTML = hex;
            this.colorChoice.setAttribute(
                "href",
                "https://dribbble.com/colors/" + hex.replace("#", "")
            );
            return hex;
        },
        fetchAndBuildShots: function () {
            var that = this;
            var hex = this.syncColors();

            this.loading();
            this.colorRange.disabled = false;

            // call api and get new shots
            var request = new XMLHttpRequest();
            request.open(
                "GET",
                "/colors/for_404.json?hex=" + hex.replace("#", ""),
                true
            );
            request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            request.onload = function () {
                if (request.status == 200) {
                    this.colorRange.disabled = false;
                    this.shots = JSON.parse(request.response).shots;
                    if (this.shots.length > 0) {
                        this.loaded();
                    }
                    this.build404Shots(this.shots);
                } else {
                    console.log("Error fetching colors.");
                }
            }.bind(this);
            request.onerror = function () {
                console.log("Error fetching colors.");
            };
            request.send();
        }
    };

    dribbble404.init();

</script>

<script>
    $(document).ready(function () {
        $('[name="graduate"]').change(function () {
            if ($('[name="graduate"]:checked').is(":checked")) {
                $('.ug').hide();
                $('.phd').show();
            } else {
                $('.ug').show();
                $('.phd').hide();
            }
        });
    });

</script>
@endsection