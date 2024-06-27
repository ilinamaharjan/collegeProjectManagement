function submitSEOForm() {
    let validationFields = ["keyword", "meta_description", "meta_title"];

    let response = this.validate(validationFields);
    if (response == 0) {
        $("#seo_form").submit();
    }
}

function setValueDropdown(id, val) {
    let inputTag = document.getElementById("searchWordsUniqueVal");
    let inputSelectDiv = document.getElementById("inputSelect");
    let checkExisting = document.getElementById("existingDataCheckModal");
    let organizationDataId = document.getElementById("organizationDataId");
    organizationDataId.value = id;

    try {
        inputSelectDiv.style.display = "none";
        inputTag.value = val;
        checkExisting.value = 0;
    } catch (error) {
        debugger;
    }
}

function setContactDropdown() {
    debugger;
}

async function searchWords(url) {
    let modelContentDiv = document.getElementById("inputSelect");
    let existingDataCheckModal = document.getElementById(
        "existingDataCheckModal"
    );
    let organizationDataId = document.getElementById("organizationDataId");
    existingDataCheckModal.value = 1;
    organizationDataId.value = "";
    let specificWord = event.target.value;
    if (specificWord == "") {
        modelContentDiv.style.display = "none";
    }
    let newUrl = url.replace("something", specificWord);
    let response = await fetch(newUrl);

    if (response.status == 200) {
        let data = await response.json();

        if (data.response == true) {
            modelContentDiv.style.display = "block";
            if (modelContentDiv.hasChildNodes() == true) {
                modelContentDiv.innerHTML = ``;
                modelContentDiv.innerHTML = data.page;
            } else {
                modelContentDiv.innerHTML = data.page;
            }
        }
    }
}

async function loadModal(url) {
    let response = await fetch(url);
    debugger;
    if (response.status == 200) {
        let data = await response.json();
        debugger;
        if (data.response == true) {
            let modelContentDiv = document.getElementById("modalContent");
            if (modelContentDiv.hasChildNodes() == true) {
                modelContentDiv.innerHTML = ``;
                createDiv(modelContentDiv, data);
            } else {
                createDiv(modelContentDiv, data);
            }
        }
    }
}

function checkSpecificPackage(event) {
    let companyDiv = document.getElementById("companyDiv");
    if (event.target.checked) {
        companyDiv.style.display = "block";
    } else {
        companyDiv.style.display = "none";
    }
}

function changeCompanyPicture() {
    const inputImage = document.getElementById("inputImage");
    const previewArea = document.getElementById("preview-image");
    const placeholder = document.getElementById("placeholder");
    const imageDiv = document.getElementById("imageDiv");
    debugger;
    let file = event.target.files[0];
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function () {
        // const img = document.createElement("img");
        imageDiv.src = reader.result;
        imageDiv.classList.add("img");
        placeholder.style.display = "none";
        // previewArea.append(img);
    };
}

function createDiv(modelContentDiv, data) {
    modelContentDiv.innerHTML = data.page;
    var c = document.getElementById("companyDiv");
    debugger;
    if (c != null) {
        c.style.display = 'none';
    }
}

function submitReCaptchaForm() {
    let validationFields = ["site_key", "secret_key"];

    let response = this.validate(validationFields);
    if (response == 0) {
        $("#seo_form").submit();
    }
}

function validate(validationFields) {
    debugger;
    let error = 0;
    validationFields.forEach((element) => {
        let el = document.querySelector("#" + element);
        let value = $("#" + element).val();
        if (value == null || value == "") {
            error++;
            // $('<span class="text-danger">Required</span>').insertAfter(el);
            $("#" + element).addClass("border border-danger");
        }
    });
    return error;
}

function keywordControl(type) {
    if (type == "add") {
        $("#jpt").append(
            '<div class="row"><div class="col"><div class="form-group"><input type="text" class="form-control" name="name[]"id="name"></div></div><div class="col"><div class="form-group "><input type="text" class="form-control" name="icon_class[]" id="icon_class"></div></div><div class="col"><div class="form-group "><input type="text" class="form-control" name="url[]" id="url"></div></div><div class="col"><div class="form-group  "><input type="file"  name="logo[]" id="logo"></div></div><div class="col-md-auto"><div class="form-group  "><a class="btn btn-danger py-1" onclick="keywordControl()">-</a></div></div></div>'
        );
    } else {
        event.target.parentElement.parentElement.parentElement.remove();
    }
}

function addOrganizationFields(name, type, idName) {
    
    let parentDiv = document.getElementById(idName);
    let childDiv = document.createElement("input");
    childDiv.classList.add("form-control");
    childDiv.classList.add("mt-1");
    childDiv.classList.add(idName);
    childDiv.setAttribute("type", type);
    childDiv.setAttribute("name", name);
    parentDiv.appendChild(childDiv);
}

function submitOrganizationForm() {
    let organizationForm = document.getElementById("org_form");
    debugger;
    let org_name = [document.getElementById("name")];
    let org_email = Array.from(document.getElementsByClassName("org_email"));
    let org_address = Array.from(
        document.getElementsByClassName("org_address")
    );
    let org_number = Array.from(document.getElementsByClassName("org_number"));

    let contactPersonName = [document.getElementById("contactPersonName")];
    let useAboveInfo = document.getElementById("useAboveInfo");
    let contactPersonNumber = document.getElementById("contactPersonNumber");
    let contactPersonEmail = document.getElementById("contactPersonEmail");

    let entries = [
        ...org_name,
        ...org_email,
        ...org_address,
        ...org_number,
        ...contactPersonName,
    ];
    debugger;
    if (useAboveInfo.checked == false || useAboveInfo.checked == "0") {
        debugger;
        entries.push(contactPersonEmail);
        entries.push(contactPersonNumber);
        debugger;
    }

    let validationRes = validateOrganizationForm(entries);
    if (validationRes == true) {
        organizationForm.submit();
        document.getElementById("orgErr").innerText = ``;
    } else {
        document.getElementById(
            "orgErr"
        ).innerText = `Please fill the highlighted fields`;
    }
}

function useAboveData() {
    if (event.target.checked == false) {
        document.getElementById("useData").style.display = "block";
    } else {
        document.getElementById("useData").style.display = "none";
    }
}

function submitContactForm() {
    let organizationForm = document.getElementById("contact_form");
    let contact_name = [document.getElementById("name")];
    let contact_email = Array.from(
        document.getElementsByClassName("contact_email")
    );
    // let contact_address = Array.from(document.getElementsByClassName('contact_address'));
    let contact_number = Array.from(
        document.getElementsByClassName("contact_number")
    );

    let entries = [...contact_name, ...contact_email, ...contact_number];
    let validationRes = validateOrganizationForm(entries);
    if (validationRes == true) {
        organizationForm.submit();
        document.getElementById("orgErr").innerText = ``;
    } else {
        document.getElementById(
            "orgErr"
        ).innerText = `Please fill the highlighted fields`;
    }
}

function toggleCustomFieldType(type, id) {
    let form = document.getElementById("customerFieldSetting");
    initializeCustomFieldToggle(form);
    let dynamicDiv = document.createElement("div");

    switch (type) {
        case "textFieldSetting":
            dynamicDiv.classList.add("row");
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
        case "dropdownFieldSetting":
            dynamicDiv.classList.add("row");
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
        if (childrenValues[i].name == "_token") {
            continue;
        } else {
            parentDiv.removeChild(childrenValues[i]);
        }
    }
}

function submitCustomFieldSetting() {
    let form = document.getElementById("customerFieldSetting");
    debugger;
    form.submit();
}

function validateOrganizationForm(entries) {
    debugger;
    let errorCount = 0;
    entries.forEach((element) => {
        if (element.value == "") {
            errorCount++;
            element.style.border = "1px solid red";
        } else {
            element.style.border = "1px solid #cccccc";
        }
    });
    if (errorCount > 0) {
        return false;
    } else {
        return true;
    }
}

function addNews(type) {
    if (type == "add") {
        $("#jpt").append(
            '<div class="row"><div class="col"><div class="form-group"><input type="text" class="form-control" name="title[]"id="title"></div></div><div class="col"><div class="form-group "><input type="text" class="form-control" name="description[]" id="description"></div></div><div class="col"><div class="form-group "><input type="text" class="form-control" name="link[]" id="link"></div></div><div class="col"><div class="form-group  "><input type="file"  name="img[]" id="img"></div></div><div class="col-md-auto"><div class="form-group  "><a class="btn btn-danger py-1" onclick="addNews()">-</a></div></div></div>'
        );
    } else {
        event.target.parentElement.parentElement.parentElement.remove();
    }
}

function showImage(id) {
    var file = event.target.files[0];
    $("#" + id).empty();

    if (file) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $("#" + id).append(
                '<img src="' + e.target.result + '" width="100" />'
            );
        };
        reader.readAsDataURL(file);
    } else {
        $("#" + id).empty();
    }
}

function toggleCard() {
    $("#media-card").show();
    $("#mediabtn").hide();
    $("#table-div").hide();
}

$(document).ready(function () {
    $("#media-card").hide();
});

function submitMediaForm() {
    let validationFields = ["name", "icon_class", "url"];

    let response = this.validate(validationFields);
    if (response == 0) {
        $("#media_form").submit();
    }
}
function submitNewsForm() {
    let validationFields = ["title", "img"];

    let response = this.validate(validationFields);
    if (response == 0) {
        $("#media_form").submit();
    }
}
function submitWebForm() {
    let validationFields = [
        "website_name",
        "address",
        "contact_number",
        "email",
    ];

    let response = this.validate(validationFields);
    if (response == 0) {
        $("#seo_form").submit();
    }
}
