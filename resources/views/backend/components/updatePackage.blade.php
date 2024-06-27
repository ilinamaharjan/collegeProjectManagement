<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Edit - {{ $package->title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="container-fluid card rounded bg-white mt-3 mb-3 customCard">
            <form action="{{ route('package.update') }}" method="POST" id="packageForm{{ $package->id }}">
                @csrf
                <input type="text" name="package_id" value="{{ $package->id }}" hidden>
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-3 py-5">
                            <label for="title" id="title">Title<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="title{{ $package->id }}" name="title"
                                value="{{ $package->title }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 py-5">
                            <label for="no_of_users" id="no_of_users">Price per User</label>
                            <input type="number" min="0" class="form-control" id="price_per_user"
                                name="price_per_user" value="{{ $package->price_per_user }}" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 py-5">
                            <label for="no_of_users" id="no_of_users">No. of users<sup
                                    class="text-danger">*</sup></label>
                            <input type="number" min="0" class="form-control"
                                id="no_of_users{{ $package->id }}" name="no_of_users"
                                value="{{ $package->no_of_users }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 py-5">
                            <label for="price" id="price">Price<sup class="text-danger">*</sup></label>
                            <input type="number" min="0" class="form-control" id="price{{ $package->id }}"
                                name="price" value="{{ $package->price }}" />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="p-3 py-2">
                            <label for="subscription_mode" id="subscription_mode">Subscription<sup
                                    class="text-danger">*</sup></label>
                            <select name="subscription_mode" class="form-control">
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Yearly">Yearly</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 py-2">
                            <label for="modules" id="modules">Modules<sup class="text-danger">*</sup></label>
                            <select name="modules[]" id="modules{{ $package->id }}" class="form-control"
                                size="5" multiple>
                                @forelse($modules as $module)
                                    @if (in_array($module['name'], $package_modules_name))
                                        <option value="{{ $module['id'] }}" selected>
                                            {{ $module['display_name'] }}</option>
                                    @else
                                        <option value="{{ $module['id'] }}">
                                            {{ $module['display_name'] }}</option>
                                    @endif
                                @empty
                                    <option value="">No data</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 py-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value=""
                                    onclick="checkSpecificPackage(event)" id="specificBox">
                                <label class="form-check-label" for="myCheckbox">
                                    Is this package specific?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="companyDiv">
                        <div class="p-3 py-2">
                            <label for="company">Companies</label>
                            <select name="company_id[]" class="form-control" size="5" multiple>
                                @forelse ($companies as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @empty
                                    <option disabled>Please first make one company, no data present now </option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row mx-2">
                    <div class="col-md-6">
                        <p id="packageErr" class="text-danger">
                        </p>
                    </div>
                </div>
                <button class="btn updateBtn mb-5 mt-5" type="button"
                    onclick="updatePackageModal({{ $package->id }})">Save</button>
                <!-- <button class="btn btn-long btn-primary mb-3 rounded">Save</button> -->
            </form>
        </div>
    </div>

</div>
<script>
    // function checkForm() {
    //     let form = document.getElementById('packageForm');
    //     debugger;
    // }
</script>
