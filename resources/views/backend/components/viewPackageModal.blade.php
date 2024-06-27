<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">{{$package->title}} Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="container-fluid card rounded bg-white mt-3 mb-3 customCard">
            <table>

                <tr>
                    <th scope="col"><b>Package Title</b> </th>
                    <th scope="col"> : {{ $package['title'] }}</th>

                </tr>
                <tr>
                    <th scope="col"><b>Price</b> </th>
                    <th scope="col"> : {{ $package['price'] }}</th>

                </tr>


                <tr>
                    <th scope="col"><b>No.of User</b> </th>
                    <th scope="col"> : {{ $package['no_of_users'] }}</th>

                </tr>
                <tr>
                    <th scope="col"><b>Price Per User</b> </th>
                    <th scope="col"> : {{ $package['price_per_user'] }}</th>
                </tr>
                <tr>
                    <th scope="col"><b>Subscription Mode</b> </th>
                    <th scope="col"> : {{ $package['subscription_mode'] }}</th>
                </tr>

            </table>
            <hr>
            Companies associated with this package are as follows:
            @forelse ($package->company as $company)
                <li>{{ $company->name }}</li>
            @empty
                <li>Currently no company has been associated with this package</li>    
            @endforelse
            <hr>
            Modules associated with this package are as follows:
            @forelse ($module_name_arr as $m_name)
                <li>{{ $m_name }}</li>
            @empty
                <li>Currently no module has been associated with this package</li>    
            @endforelse
        </div>
    </div>

</div>
