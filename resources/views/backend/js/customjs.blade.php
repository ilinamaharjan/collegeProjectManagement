<script>
    function submitSEOForm() {
        let validationFields = [
            'keyword', 'meta_description', 'meta_title'
        ];

        let response = this.validate(validationFields);
        if (response == 0) {
            $('#seo_form').submit();
        }

    }

    function setValueDropdown(id, val) {
        let inputTag = document.getElementById('searchWordsUniqueVal');
        let inputSelectDiv = document.getElementById('inputSelect');
        let checkExisting = document.getElementById('existingDataCheckModal');
        let organizationDataId = document.getElementById('organizationDataId');
        organizationDataId.value = id;

        try {
            inputSelectDiv.style.display = 'none';
            inputTag.value = val;
            checkExisting.value = 0;
        } catch (error) {


        }
    }

    function setContactDropdown() {

    }

    async function searchWords(url) {
        let modelContentDiv = document.getElementById('inputSelect');
        let existingDataCheckModal = document.getElementById('existingDataCheckModal');
        let organizationDataId = document.getElementById('organizationDataId');
        existingDataCheckModal.value = 1;
        organizationDataId.value = '';
        let specificWord = event.target.value;
        if (specificWord == "") {
            modelContentDiv.style.display = 'none';
        }
        let newUrl = url.replace('something', specificWord);
        let response = await fetch(newUrl);

        if (response.status == 200) {
            let data = await response.json();

            if (data.response == true) {
                modelContentDiv.style.display = 'block';
                if (modelContentDiv.hasChildNodes() == true) {
                    modelContentDiv.innerHTML = ``;
                    modelContentDiv.innerHTML = data.page;
                } else {
                    modelContentDiv.innerHTML = data.page;
                }

            }
        }
    }

    async function submitLeadFile(url) {
        let form = document.getElementById('leadFileForm')
        let formData = new FormData(form);
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
                getRespectiveFiles(data.typeId);
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

    async function getRespectiveFiles(idVal) {
        let leadId = document.getElementById('leadId').value;
        let formData = new FormData();
        formData.append('lead_id', leadId);
        formData.append('file_type_id', idVal);
        let url = "{{ route('ajax.getLeadFiles') }}";
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
                let dynamicFileDiv = document.getElementById('dynamicFileDiv');
                dynamicFileDiv.innerHTML = data.page;
            } else {

            }

        }

    }

    async function loadModal(url) {
        let response = await fetch(url);
        if (response.status == 200) {
            let data = await response.json();

            if (data.response == true) {
                let modelContentDiv = document.getElementById('modalContent');

                if (modelContentDiv.hasChildNodes() == true) {
                    modelContentDiv.innerHTML = ``;
                    debugger;
                    createDiv(modelContentDiv, data);
                } else {
debugger;
                    createDiv(modelContentDiv, data);
                }
            }
        }
    }

    function checkSpecificPackage(event) {
        let companyDiv = document.getElementById('companyDiv');
        if (event.target.checked) {
            companyDiv.style.display = 'block';
        } else {
            companyDiv.style.display = 'none';
        }
    }

    function changeCompanyPicture() {
        const inputImage = document.getElementById("inputImage");
        const previewArea = document.getElementById("preview-image");
        const placeholder = document.getElementById("placeholder");
        const imageDiv = document.getElementById('imageDiv');

        let file = event.target.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function() {
            // const img = document.createElement("img");
            imageDiv.src = reader.result;
            imageDiv.classList.add("img");
            placeholder.style.display = "none";
            // previewArea.append(img);
        };
    }

    function createDiv(modelContentDiv, data) {
        modelContentDiv.innerHTML = data.page;

        var c = document.getElementById('companyDiv');
        debugger

        if (c != null) {
            c.style.display = 'none';
            
        }

    }

    function submitReCaptchaForm() {
        let validationFields = [
            'site_key', 'secret_key'
        ];

        let response = this.validate(validationFields);
        if (response == 0) {
            $('#seo_form').submit();
        }
    }

    function validate(validationFields) {
        let error = 0;
        validationFields.forEach(element => {
            let el = document.querySelector("#" + element);
            let value = $('#' + element).val();
            if (value == null || value == '') {
                error++;
                // $('<span class="text-danger">Required</span>').insertAfter(el);
                $('#' + element).addClass('border border-danger');
            }
        });
        return error;
    }

    function keywordControl(type) {
        if (type == 'add') {
            $('#jpt').append(
                '<div class="row"><div class="col"><div class="form-group"><input type="text" class="form-control" name="name[]"id="name"></div></div><div class="col"><div class="form-group "><input type="text" class="form-control" name="icon_class[]" id="icon_class"></div></div><div class="col"><div class="form-group "><input type="text" class="form-control" name="url[]" id="url"></div></div><div class="col"><div class="form-group  "><input type="file"  name="logo[]" id="logo"></div></div><div class="col-md-auto"><div class="form-group  "><a class="btn btn-danger py-1" onclick="keywordControl()">-</a></div></div></div>'
            )
        } else {
            event.target.parentElement.parentElement.parentElement.remove();
        }
    }

    // function addOrganizationFields(name, type, idName) {
    //     let parentDiv = document.getElementById(idName);
    //     let childDiv = document.createElement('input');
    //     childDiv.classList.add('form-control');
    //     childDiv.classList.add('mt-1');
    //     childDiv.classList.add(idName);
    //     childDiv.setAttribute("type", type);
    //     childDiv.setAttribute("name", name);;
    //     parentDiv.appendChild(childDiv);
    // }
    // update with remove icon 
    function addOrganizationFields(name, type, idName) {
        let parentDiv = document.getElementById(idName);
        let childDiv = document.createElement('div');
        childDiv.classList.add('mt-1');
        parentDiv.appendChild(childDiv);
        $(childDiv).append( `<input type="${type}" class="${idName}  form-control input-append customer" name="${name}" /><span><i onclick="removeInputField()" class='fa fa-trash customer' aria-hidden='true'></i></span>`);
    }
    function removeInputField(){
        let icon=event.target.parentElement.parentElement;
        icon.remove();
    } 
    
    
    function submitOrganizationForm() {
        let organizationForm = document.getElementById('org_form');


        let org_name = document.getElementById('name');
        let org_email = Array.from(document.getElementsByClassName('org_email'));
        let org_address = Array.from(document.getElementsByClassName('org_address'));
        let org_number = Array.from(document.getElementsByClassName('org_number'));

        let contactPersonName = document.getElementById("contactPersonName");

        let contactPersonEmail = Array.from(document.getElementsByClassName('contact_email'));
        let contactPersonNumber = Array.from(document.getElementsByClassName('contact_person_numbers'));

        let entries = [contactPersonName, ...contactPersonNumber, ...contactPersonEmail];

        if (org_name.value != '') {

            entries.push(org_name);
            entries.push(...org_email);
            entries.push(...org_address);
            entries.push(...org_number);
        }

        let validationRes = validateUpdateOrgForm(entries);
        document.getElementById('orgErr').innerText = ``;
        document.getElementById('emailErr').innerText = ``;

        if (validationRes == true) {

            organizationForm.submit();
            document.getElementById('orgErr').innerText = ``;
            document.getElementById('emailErr').innerText = ``;

        } else if (validationRes == "email") {

            document.getElementById('emailErr').innerText =
                `Please enter valid email.`;
            document.getElementById('orgErr').innerText = ``;

        } else if (validationRes == "both") {

            document.getElementById('orgErr').innerText = `Please fill the highlighted fields`;
            document.getElementById('emailErr').innerText =
                `Please enter valid email.`;

        } else {
            document.getElementById('orgErr').innerText = `Please fill the highlighted fields`;
            document.getElementById('emailErr').innerText = ``;
        }
    }

    // updateOrganizationModal.blade.php
    function updateOrganizationForm(key) {

        let organizationForm = document.getElementById('org_form' + key);
        let updateorganizationId = document.getElementById('updateorganizationModal' + key);


        let contactPersonName = document.getElementById('contactPersonUpdate' + key);

        let contactPersonEmail = Array.from(document.getElementsByClassName('contact_email_update' + key));
        let contactPersonNumber = Array.from(document.getElementsByClassName('contact_number_update' + key));

        let entries = [contactPersonName, ...contactPersonNumber, ...contactPersonEmail];
        if (updateorganizationId.value != '' && updateorganizationId.value != null && updateorganizationId.value !=
            undefined) {
            let org_name = document.getElementById('org_name_update' + key);
            let org_email = Array.from(document.getElementsByClassName('org_email_update' + key));
            let org_address = Array.from(document.getElementsByClassName('org_address_update' + key));
            let org_number = Array.from(document.getElementsByClassName('org_number_update' + key));

            entries.push(org_name);
            entries.push(...org_email);
            entries.push(...org_address);
            entries.push(...org_number);
        }

        let validationRes = validateUpdateOrgForm(entries);
        document.getElementById('orgErr' + key).innerText = ``;
        document.getElementById('emailErr' + key).innerText = ``;

        if (validationRes == true) {

            organizationForm.submit();
            document.getElementById('orgErr' + key).innerText = ``;
            document.getElementById('emailErr' + key).innerText = ``;

        } else if (validationRes == "email") {

            document.getElementById('emailErr' + key).innerText =
                `Please enter valid email.`;
            document.getElementById('orgErr' + key).innerText = ``;

        } else if (validationRes == "both") {

            document.getElementById('orgErr' + key).innerText = `Please fill the highlighted fields`;
            document.getElementById('emailErr' + key).innerText =
                `Please enter valid email.`;

        } else {
            document.getElementById('orgErr' + key).innerText = `Please fill the highlighted fields`;
            document.getElementById('emailErr' + key).innerText = ``;
        }
    }

    function validateUpdateOrgForm(entries) {

        let errorCount = 0;
        let emailCount = 0;

        entries.forEach(element => {
            element.style.border = '1px solid #cacaca';

            if (element.value == '') {
                errorCount++;
                element.style.border = '1px solid red';
            } else {

                let validRegex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (element.type == 'email') {
                    if (!element.value.match(validRegex)) {

                        emailCount++;
                        element.style.border = '1px solid red';

                    } else {

                        element.style.border = '1px solid #cacaca';
                    }
                }
            }

        });
        if (errorCount > 0 && emailCount == 0) {
            return false;
        } else if (emailCount > 0 && errorCount == 0) {
            return "email";

        } else if (errorCount > 0 && emailCount > 0) {
            return "both";
        } else {
            return true;
        }
    }

    function useAboveData() {
        if (event.target.checked == false) {
            document.getElementById('useData').style.display = 'block';
        } else {
            document.getElementById('useData').style.display = 'none';
        }
    }

    function submitContactForm() {
        let organizationForm = document.getElementById('contact_form');
        let contact_name = [document.getElementById('name')];
        let contact_email = Array.from(document.getElementsByClassName('contact_email'));
        // let contact_address = Array.from(document.getElementsByClassName('contact_address'));
        let contact_number = Array.from(document.getElementsByClassName('contact_number'));

        let entries = [...contact_name, ...contact_email, ...contact_number];

        let validationRes = validateOrganizationForm(entries);
        if (validationRes == true) {
            organizationForm.submit();
            document.getElementById('orgErr').innerText = ``;
        } else {
            document.getElementById('orgErr').innerText = `Please fill the highlighted fields`;
        }
    }

    function toggleCustomFieldType(type, id) {
        let form = document.getElementById('customerFieldSetting');
        initializeCustomFieldToggle(form);
        let dynamicDiv = document.createElement('div');

        switch (type) {
            case 'textFieldSetting':
                dynamicDiv.classList.add('row');
                dynamicDiv.innerHTML = `
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Field Name : </label>
                        <input type="text" class="form-control" name="field_name">
                        <input type="text" name="type" value="text" hidden>
                        <input type="text" name="field_type_id" value="${id}" hidden>
                        
                    </div>
                </div>
                `;
                form.appendChild(dynamicDiv);
                break;
            case 'dropdownFieldSetting':
                dynamicDiv.classList.add('row');
                dynamicDiv.innerHTML = `
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Field Name</label>
                        <input type="text" class="form-control" name="field_name">
                        <input type="text" name="type" value="dropdown" hidden>
                        <input type="text" name="field_type_id" value="${id}" hidden>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Options [Note should be separeted by comma]</label>
                        <input type="text" class="form-control" name="options">
                    </div>
                </div>
                `;
                form.appendChild(dynamicDiv);
                break;
            default:
                break;
        }
    }

    function initializeCustomFieldToggle(parentDiv) {
        let childrenValues = Array.from(parentDiv.children);
        for (let i = 0; i < childrenValues.length; i++) {
            if ((childrenValues[i].name == '_token')) {
                continue;
            } else {
                parentDiv.removeChild(childrenValues[i]);
            }
        }
    }
    // Start of Excel form in contact book index blade.
    function submitExcelFile() {
        let excelform = document.getElementById('excelform');
        let image = document.getElementById('imagefile');
        if (image.value != '' && image.value != null && image.value != undefined) {

            let type = ['xls', 'xlsx'];
            let imgtype = image.files[0].name.split(".").pop().toLowerCase();
            if (type.includes(imgtype)) {
                document.getElementById('Excelfilevalidate').innerText = ``;
                excelform.submit();
            } else {
                document.getElementById('Excelfilevalidate').innerText = `Please add  only .xls or .xslx file`;
            }
        } else {
            image.style.border = "1px solid red";
            document.getElementById('Excelfilevalidate').innerText = `Please choose excel file`;
        }
    }
    //End excel form validation.

    // update package modal validation
    function updatePackageModal(key) {
        let packageForm = document.getElementById('packageForm' + key);
        let title = document.getElementById('title' + key);
        let no_of_users = document.getElementById('no_of_users' + key);
        let price = document.getElementById('price' + key);
        let modules = document.getElementById('modules' + key);

        let entries = [title, no_of_users, price, modules];

        let validationResponse = validateOrganizationForm(entries);
        if (validationResponse == true) {
            packageForm.submit();
            document.getElementById('packageErr').innerText = ``;
        } else {
            document.getElementById('packageErr').innerText = `Please fill the highlighted fields`;
        }

    }
    //end update package

    // Company setup form validation
    function companySetupSubmit() {

        let companyCreateform = document.getElementById('companyCreateform');
        let name = document.getElementById('name');
        let email = document.getElementById('email');
        let total_employees = document.getElementById('total_employees');
        var validRegex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        // let phone_number = document.getElementById('phone_number');
        // let address = document.getElementById('address');
        // let website = document.getElementById('website');
        // let entries = [name, email, phone_number, address, total_employees, website];
        let entries = [name, email, total_employees];

        let companyValidateResp = validateCompanydata(entries);

        document.getElementById('companyErr').innerText = ``;
        document.getElementById('emailErr').innerText = ``;

        if (companyValidateResp == true) {

            companyCreateform.submit();
            document.getElementById('companyErr').innerText = ``;
            document.getElementById('emailErr').innerText = ``;

        } else if (companyValidateResp == "email") {

            document.getElementById('emailErr').innerText =
                `Please enter valid email.`;
            document.getElementById('companyErr').innerText = ``;

        } else if (companyValidateResp == "both") {

            document.getElementById('companyErr').innerText = `Please fill the highlighted fields`;
            document.getElementById('emailErr').innerText =
                `Please enter valid email.`;

        } else {
            document.getElementById('companyErr').innerText = `Please fill the highlighted fields`;
            document.getElementById('emailErr').innerText = ``;
        }
    }

    function validateCompanydata(entries) {

        let errorCount = 0;
        let emailCount = 0;
        entries.forEach(element => {
            element.style.border = '1px solid #cacaca';
            if (element.value == '') {
                errorCount++;
                element.style.border = '1px solid red';
            } else {
                if (element.type == 'email') {
                    var validRegex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    if (!element.value.match(validRegex)) {
                        emailCount++;
                        element.style.border = '1px solid red';

                    } else {
                        element.style.border = '1px solid #cacaca';
                    }
                } else {
                    element.style.border = '1px solid #cacaca';
                }
            }

        });

        if (errorCount > 0 && emailCount == 0) {
            return false;
        } else if (emailCount == 1 && errorCount == 0) {
            return "email";

        } else if (errorCount > 0 && emailCount == 1) {
            return "both";
        } else {
            return true;
        }

    }
    //End company setup

    // Start update company form
    function submitCompanyUpdate(key) {

        let updatecompanyform = document.getElementById('updatecompanyform' + key);

        let name = document.getElementById('name' + key);
        let email = document.getElementById('email' + key);
        let total_employees = document.getElementById('total_employees' + key);
        var validRegex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        let entries = [name, email, total_employees];

        let updateCompanyValidateResp = validateCompanydata(entries);

        document.getElementById('companyErr').innerText = ``;
        document.getElementById('emailErr').innerText = ``;

        if (updateCompanyValidateResp == true) {

            updatecompanyform.submit();
            document.getElementById('companyErr').innerText = ``;
            document.getElementById('emailErr').innerText = ``;

        } else if (updateCompanyValidateResp == "email") {

            document.getElementById('emailErr').innerText =
                `Please enter valid email.`;
            document.getElementById('companyErr').innerText = ``;

        } else if (updateCompanyValidateResp == "both") {

            document.getElementById('companyErr').innerText = `Please fill the highlighted fields`;
            document.getElementById('emailErr').innerText =
                `Please enter valid email.`;

        } else {
            document.getElementById('companyErr').innerText = `Please fill the highlighted fields`;
            document.getElementById('emailErr').innerText = ``;
        }
    }
    // End update company form

    // user setup form validation
    function userCreateSubmit() {

        let profileForm = document.getElementById('profileForm');
        let username = document.getElementById('username');
        let name = document.getElementById('name');
        let email = document.getElementById('email');
        // let personal_number = document.getElementById('personal_number');
        // let office_number = document.getElementById('office_number');
        // let permanent_address = document.getElementById('permanent_address');
        // let temporary_address = document.getElementById('temporary_address');
        // let designation = document.getElementById('designation');
        // let entries = [username, name, email, personal_number, office_number, permanent_address, temporary_address,
        //     designation
        // ];
        let entries = [username, name, email];
        let userValidateResp = validateCompanydata(entries);

        // if (userValidateResp == true) {
        //     profileForm.submit();
        //     document.getElementById('errDiv').innerText = ``;
        // } else {
        //     document.getElementById('errDiv').innerText = `Please fill the highlighted fields`;
        // }
        document.getElementById('errDiv').innerText = ``;
        document.getElementById('emailErr').innerText = ``;

        if (userValidateResp == true) {

            profileForm.submit();
            document.getElementById('errDiv').innerText = ``;
            document.getElementById('emailErr').innerText = ``;

        } else if (userValidateResp == "email") {

            document.getElementById('emailErr').innerText =
                `Please enter valid email.`;
            document.getElementById('errDiv').innerText = ``;

        } else if (userValidateResp == "both") {

            document.getElementById('errDiv').innerText = `Please fill the highlighted fields`;
            document.getElementById('emailErr').innerText =
                `Please enter valid email.`;

        } else {
            document.getElementById('errDiv').innerText = `Please fill the highlighted fields`;
            document.getElementById('emailErr').innerText = ``;
        }




    }
    // End user setup


    function submitCustomFieldSetting() {

        let form = document.getElementById('customerFieldSetting');

        form.submit();
    }

    function validateOrganizationForm(entries) {

        let errorCount = 0;
        entries.forEach(element => {
            if (element.value == '') {
                errorCount++;
                element.style.border = '1px solid red';
            } else {
                element.style.border = '1px solid #cacaca';
            }
        });

        if (errorCount > 0) {
            return false;
        } else {
            return true;
        }

    }

    function addNews(type) {
        if (type == 'add') {
            $('#jpt').append(
                '<div class="row"><div class="col"><div class="form-group"><input type="text" class="form-control" name="title[]"id="title"></div></div><div class="col"><div class="form-group "><input type="text" class="form-control" name="description[]" id="description"></div></div><div class="col"><div class="form-group "><input type="text" class="form-control" name="link[]" id="link"></div></div><div class="col"><div class="form-group  "><input type="file"  name="img[]" id="img"></div></div><div class="col-md-auto"><div class="form-group  "><a class="btn btn-danger py-1" onclick="addNews()">-</a></div></div></div>'
            )
        } else {
            event.target.parentElement.parentElement.parentElement.remove();
        }
    }

    function showImage(id) {
        var file = event.target.files[0];
        $('#' + id).empty();

        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#' + id).append('<img src="' + e.target.result + '" width="100" />');
            }
            reader.readAsDataURL(file);
        } else {
            $('#' + id).empty();
        }
    }

    function toggleCard() {
        $('#media-card').show();
        $('#mediabtn').hide();
        $('#table-div').hide();
    }

    $(document).ready(function() {
        $('#media-card').hide();

    });

    function submitMediaForm() {
        let validationFields = [
            'name', 'icon_class', 'url'
        ];

        let response = this.validate(validationFields);
        if (response == 0) {
            $('#media_form').submit();
        }
    }

    function submitNewsForm() {
        let validationFields = [
            'title', 'img'
        ];

        let response = this.validate(validationFields);
        if (response == 0) {
            $('#media_form').submit();
        }
    }

    function submitWebForm() {
        let validationFields = [
            'website_name', 'address', 'contact_number', 'email'
        ];

        let response = this.validate(validationFields);
        if (response == 0) {
            $('#seo_form').submit();
        }
    }

    async function linkActivity(fileId) {
        let id = event.target.value;
        let form = new FormData();
        form.append('id', fileId);
        form.append('activity_id', id);
        let url = "{{ route('lead_file.linkActivity') }}";
        let requestOptions = {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            method: "POST",
            body: form
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

    function showForm() {
        let btn = event.target;
        var x = document.getElementById("classone");

        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }


    const buttonGroup = document.getElementById("button-group");
    let prevButton = null;
    const buttonPressed = (e) => {
        if (e.target.nodeName === 'BUTTON') {
            e.target.classList.add('active');
            if (prevButton !== null) {
                prevButton.classList.remove('active');
            }
            prevButton = e.target;
        }
    }
    buttonGroup.addEventListener("click", buttonPressed);


    function updateOrganizationContactForm(key){
        let allField=$('#org_form'+key).find('input');
        let error=0;
        $.each(allField, function (indexInArray, element) { 

             let name=element.name;
             let type=element.type;
             let val=element.value;
             $(element).removeClass('border border-danger');
             let nextEl=$(element).next();
             if($(nextEl).prop('tagName')=="SMALL"){
                $(nextEl).remove();
             }
             if(type=="text" || type=="email"){
                if(val=="" || val==null || val==undefined){
                    error++;
                    $(element).addClass('border border-danger');
                }else{
                    let validRegex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    if (type == 'email') {
                        if (!val.match(validRegex)) {
                            error++;
                            $(element).addClass('border border-danger');
                            $(`<small class="text-danger">Email not valid</small>`).insertAfter($(element));
                        } 
                    }
                    if(name.includes('number')){
                        var regex = /^\+|\d+$/; 
                        if(!regex.test(val)){
                            error++;
                            $(element).addClass('border border-danger');
                            $(`<small class="text-danger">Contact number not valid</small>`).insertAfter($(element));
                        }
                    }
                }
            }
        });
        if(error==0){
            $('#org_form'+key).submit();
        }
    }

    function removeSecondaryContact(id){
        $(document).ready(function() {
            $('.swal2-container').css('z-index', '9999999999');
        });
        Swal.fire({
            title: 'Are you sure want to delete this?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: "{{ route('organization.secondaryContactDelete') }}",
                    data: {id:id},
                    success: function (response) {
                        if (response.status == true) {
                            $('#org_contact_delete_div'+id).remove();
                            Swal.fire({
                                title: response.message,
                                icon: 'success',
                                position: "top-right",
                                timer: 3000,
                                toast: true,
                                showCancelButton: false,
                                showConfirmButton: false
                            })
                        } else {
                            Swal.fire({
                                title: response.message,
                                icon: 'error',
                                position: "top-right",
                                timer: 3000,
                                toast: true,
                                showCancelButton: false,
                                showConfirmButton: false
                            })
                        }
                    }
                });
            }
        });
    }


    function deleteConfirmationFunction(id,route,model){
       
        Swal.fire({
            title: `Are you sure?`,
            text:  `But you will still be able to retrieve this  ${model}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: route,
                    data: {id:id},
                    success: function (res) {
                        if (res.response == true) {
                            Swal.fire({
                                title: res.message,
                                icon: 'success',
                                position: "top-right",
                                timer: 3000,
                                toast: true,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            // window.location.reload();
                            getRoleAllData();
                        } else {
                            Swal.fire({
                                title: res.message,
                                icon: 'error',
                                position: "top-right",
                                timer: 3000,
                                toast: true,
                                showCancelButton: false,
                                showConfirmButton: false
                            })
                        }
                    }
                });
            }
        });
    }


    // user enable disable 
    function toggleSwitch(id) {
        var checkbox = document.getElementById("customSwitch"+id);
        checkbox.checked = !checkbox.checked;

        if (checkbox.checked) {
                Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to enable this user?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
                }).then((result) => {
                if (result.value) {
                    userStatusAjax(id,1);
                } else {
                    checkbox.checked = false;
                }
            });
        } else {
        Swal.fire({
          title: 'Are you sure?',
          text: 'Do you want to disable this user?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No'
        }).then((result) => {
          if (result.value) {
            userStatusAjax(id,0);
          } else {
            checkbox.checked = true;
          }
        });
      }

      }

      function userStatusAjax(id,status){
        $.ajax({
                type: "get",
                url: "{{ route('user_management.userStatusUpdate') }}",
                data: {
                    id:id,
                    status:status
                },
                success: function (res) {
                    if(res.response==true){
                        
                        getRoleAllData();
                         Swal.fire({
                            title: 'Updated!',
                            text: res.message,
                            icon: 'success',
                        });
                        if(res.own!=null){
                            window.location.reload();
                        }
                    }else{
                        Swal.fire({
                            title: 'Error',
                            text: res.message,
                            icon: 'error',
                        });
                    }
                }
            });
      }
  
</script>
