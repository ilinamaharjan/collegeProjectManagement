<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title  pageMainTitle">Custom Field Setup </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="p-3">
            <div class="row" id="customer-field-section">
                <div class="col-md-6">
                    <button onclick="toggleCustomFieldType('textFieldSetting',{{ $type_id }})"
                        style="width:400px;">
                        <p class="p-1">Text</p>
                    </button>
                </div>
                <div class="col-md-6">
                    <button
                        onclick="toggleCustomFieldType('dropdownFieldSetting',{{ $type_id }})"style="width:400px;">
                        <p class="p-1">Dropdown</p>
                    </button>
                </div>
            </div>

            <form action="{{ route('custom_field.store') }}" id="customerFieldSetting" method="POST">
                @csrf
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="submitCustomFieldSetting()" class="btn btn-primary lead">Submit</button>
    </div>
</div>

<script>
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
</script>
