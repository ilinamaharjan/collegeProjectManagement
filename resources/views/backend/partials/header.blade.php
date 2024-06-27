<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                <i class="ti-menu"></i>
            </a>
            <div class="mobile-search waves-effect waves-light">
                <div class="header-search">
                    <div class="main-search morphsearch-search">
                        <div class="input-group">
                            <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                            <input type="text" class="form-control" placeholder="Enter Keyword">
                            <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="crmMainTitle"><span style="color:#f6b619;text-transform:capitalize;">PM Software</h4>
            <a class="mobile-options waves-effect waves-light">
                <i class="ti-more"></i>
            </a>
        </div>

        <div class="navbar-container container-fluid">
            <ul class="nav-left">

                <li>
                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                </li>
                <hr>
            </ul>
            <ul class="nav-right">

                <li class="header-search">
                    <div class="input-box">
                        <i class="fa fa-search"></i>
                        <input id="input1" placeholder="Search " />

                    </div>
                </li>

                <li class="filter"><i class="fa fa-filter" aria-hidden="true"></i></li>


                <li class="header-no" id="showNotification">

                </li>

                <li class="header-message">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <ul>

                    </ul>
                </li>


                <li>

                    <div class="profile-details" style="margin-right:-25px;">
                        <img src="{{ auth()->user()->hasMedia('profile-photo') ? auth()->user()->getMedia('profile-photo')[0]->getFullUrl() : 'backend/images/avatar-1.jpg' }}"
                            class="img-fluid innersection" alt="profileImg"
                            style="height: 44px;width:25%;margin-right: -12px;margin-top: 4px;">
                        <div class="name_job">
                            <div class="name">{{ auth()->user()->name }}</div>
                        </div>
                    </div>
                </li>

                <li class="user-profile header-notification">
                    <a href="#" class="waves-effect waves-light">
                        <i class="ti-angle-down" style="font-weight:bold;"></i>
                    </a>

                    <ul class="show-notification profile-notification">

                        <li class="waves-effect waves-light">
                            <a href="{{ route('home.profile') }}">
                                <i class="ti-user"></i><b> Profile</b>
                            </a>
                        </li>
                        @can('View|Company')
                        <li class="waves-effect waves-light">
                            <a href="{{ route('home.company') }}">
                                <i class="fa fa-building-o"></i><b>Company Profile</b>
                            </a>
                        </li>
                        @endcan
                        <li class="waves-effect waves-light">
                            <a data-toggle="modal" data-target="#modalPush">
                                <i class="ti-lock"></i><b> Change Password</b>
                            </a>

                        </li>
                        <li class="waves-effect waves-light">
                            <a href="{{ route('home.logout') }}">
                                <i class="ti-layout-sidebar-left"></i> <b>Logout</b>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <form action="{{ route('changePassword') }}" method="POST" id="changePwdForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header" style="background-color: #375893">
                    <h5 class="modal-title text-white" id="exampleModalLongTitle">Change Password</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="form-label">Current Password</label>
                                <input type="text" class="form-control" id="current_pwd"
                                    onchange="checkCurrentPassword()">
                                <p class="text-danger" id="pwdErr"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="form-label">New Password</label>
                                <input type="text" class="form-control" name="new_pwd" id="new_pwd"
                                    onchange="validatePassword()">
                                <p class="text-danger" id="valid_pwd"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="changeBtn" class="btn btn-primary"
                        onclick="submitChangePassword()">Change</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    window.addEventListener('load', () => {
        this.getNotifications();
    });

    // Bell Notification Object
    let bellObj = {
        isClicked : 0
    };

    function toggleBell(id) {
        let containerDiv = document.getElementById(id);
        if (bellObj,isClicked == 0) {
            bellObj.isClicked = 1
            containerDiv.style.display = 'block'
        } else {
            bellObj.isClicked = 0;
            containerDiv.style.display = '';
        }
    }

    function getNotificationDetail(notificationId) {
        let url = "{{ route('ajax.getNotificationDetails', ':p') }}";
        let newUrl = url.replace(':p',notificationId);
        loadModal(newUrl);
    }

    async function getNotifications() {
        let url = "{{route('ajax.getNotifications')}}";
        let response = await fetch(url);
        if (response.status == 200) {
            let data = await response.json();
            document.getElementById('showNotification').innerHTML = data.page;
        }
    }

    // Notification getter called every minute.
    setInterval(getNotifications,60000);




    async function checkCurrentPassword() {
        let url = "{{ route('verifyPassword') }}";
        let formData = new FormData();
        formData.append('pwd', event.target.value);
        let requestOptions = {
            method: 'POST',
            headers: {
                'X-CSRF-Token': "{{ csrf_token() }}"
            },
            body: formData
        };

        let response = await fetch(url, requestOptions);
        if (response.status == 200) {
            let errDiv = document.getElementById('pwdErr');
            let data = await response.json();
            if (data.response == false) {
                errDiv.innerText = data.message;
                document.getElementById('changeBtn').style.display = 'none';
            } else {
                errDiv.innerText = '';
                document.getElementById('changeBtn').style.display = 'block';

            }
        }
    }

    function validatePassword() {
        let errCount = 0;
        let errDiv = document.getElementById('valid_pwd');
        let password = document.getElementById('new_pwd').value;
        if (password == '') {
            errDiv.innerText = 'Password cannot be null';
            errCount++;
        } else if (password.length < 8) {
            errDiv.innerText = 'Password must be at least 8 characters';
            errCount++;
        } else if (password.search(/[a-z]/) < 0) {
            errDiv.innerText = 'Password must contain at least one lowercase letter';
            errCount++;
        } else if (password.search(/[A-Z]/) < 0) {
            errDiv.innerText = 'Password must contain at least one uppercase letter';
            errCount++;
        } else if (password.search(/[0-9]/) < 0) {
            errDiv.innerText = 'Password must contain at least one number';
            errCount++;
        } else {
            errDiv.innerText = '';
        }

        if (errCount > 0) {
            return false;
        } else {
            return true;
        }
    }



    function submitChangePassword() {
        let validationRes = validatePassword();
        let form = document.getElementById('changePwdForm');
        if (validationRes == true) {
            form.submit();
        }
    }

</script>
