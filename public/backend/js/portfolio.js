export function changePhoto() {
    let imagePreviewDiv = document.getElementById('imagePreview');
    if (event.target.files.length > 0) {
        let file = event.target.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function() {
            imagePreviewDiv.src = reader.result;
        };
    } else {
        imagePreviewDiv.src = 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg';
    }
}

export function updateProfile(){
    let form = document.getElementById('profileForm');
    let entries = [document.getElementById('name') , document.getElementById('email')];
    let validationRes = validateProfile(entries);
    if (validationRes == true) {
        form.submit();
    }
}

export function validateProfile(entries) {
    let errCount = 0;
    entries.forEach(element => {
        if (element.value == '') {
            errCount++
            element.style.border = '1px solid red';
        }else{
            element.style.border = '1px solid #cccccc';
        }
    });

    if (errCount > 0) {
        document.getElementById('errDiv').innerText = 'Please fill the highlighted fields';
        return false;
    } else {
        document.getElementById('errDiv').innerText = '';
        return true;
    }
}