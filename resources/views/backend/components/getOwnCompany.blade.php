<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="pageMainTitle modal-title">{{ $company->name }} Details </h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="width:70%;">
            <div class="d-flex bd-highlight mb-3">
                <div class="align-self-center">
                    <img src="{{ $company->hasMedia('company-logo') ? $company->getMedia('company-logo')[0]->getFullUrl() : 'backend/images/avatar-1.jpg' }}"
                        class="img-fluid customImage" alt="company logo" style="height:130px; width:130px;">
                </div>
                <div class="align-self-center p-3 bd-highlight">

                    <table class="table">
                        <thead>
                            <tr>



                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="col"><b>Full Company's Name</b> </th>
                                <th scope="col"> : {{ $company['name'] }}</th>

                            </tr>
                            <tr>
                                <th scope="col"><b>Contact</b> </th>
                                <th scope="col"> : {{ $company['phone_number'] }}</th>

                            </tr>
                            <tr>
                                <th scope="col"><b>Email</b> </th>
                                <th scope="col"> : {{ $company['email'] }}</th>

                            </tr>
                            <tr>
                                <th scope="col"><b>Total Employee</b> </th>
                                <th scope="col"> : {{ $company['total_employees'] }}</th>

                            </tr>

                            <tr>
                                <th scope="col"><b>URL</b> </th>
                                <th scope="col"> : {{ $company['website'] }}</th>

                            </tr>
                            <tr>
                                <th scope="col"><b>Package Used</b> </th>
                                <th scope="col"> : {{ $company->package->title }}</th>

                            </tr>
                        </tbody>
                    </table>



                </div>
            </div>
        </div>

    </div>
</div>
