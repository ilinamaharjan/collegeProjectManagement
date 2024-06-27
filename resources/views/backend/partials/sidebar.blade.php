<div class="pcoded-inner-navbar main-menu mt-5">
    <ul class="pcoded-item pcoded-left-item">

        <li class="{{ Route::is('home.home') ? 'sidebar-active' : '' }}">
            <a href="{{ route('home.home') }}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-tachometer main-icon"></i>
                Dashboard
            </a>
        </li>

        {{-- @can('View|Package')
            <li class="{{ Route::is('home.package') ? 'sidebar-active' : '' }}">
                <a href="{{ route('package.viewpackage') }}" class="waves-effect waves-dark sidebarCustom">
                    <i class="fa fa-sticky-note main-icon"></i>
                    Package
                </a>
            </li>
        @endcan --}}
        @can('View|Company')
            <li class="{{ Route::is('company.viewCompanies') ? 'sidebar-active' : '' }}">
                <a href="{{ route('company.viewCompanies') }}" class="waves-effect waves-dark sidebarCustom">
                    <i class="fa fa-building-o main-icon"></i>
                    Company
                </a>
            </li>
        @endcan

        @can('View|Company')
            <li class="{{ Route::is('department.viewdepartments') ? 'sidebar-active' : '' }}">
                <a href="{{ route('department.viewdepartments') }}" class="waves-effect waves-dark sidebarCustom">
                    <i class="fa fa-building-o main-icon"></i>
                    Department
                </a>
            </li>
        @endcan
        {{-- @can('View|Contact Organization')
            <li class="{{ Route::is('organization.index') ? 'sidebar-active' : '' }}">
                <a href="{{ route('organization.index') }}" class="waves-effect waves-dark sidebarCustom">
                    <i class="fa fa-building-o main-icon"></i>

                    Contact Book
                </a>
            </li>
        @endcan --}}
        {{-- @can('View|Contact Person')
        <li class="{{Route::is('contact.index')?'sidebar-active':''}}">
            <a href="{{ route('contact.index') }}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-user main-icon"></i>
                Contact Person
            </a>
        </li>
        @endcan --}}

        {{-- <li class="{{Route::is('home.organization')?'sidebar-active':''}}">
            <a href="{{ route('home.organization') }}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-sticky-note main-icon"></i>
                Organization
            </a>
        </li> --}}


        {{-- @can('View|Lead')
            <li class="{{ Route::is('home.lead') ? 'sidebar-active' : '' }}">
                <a href="{{ route('home.lead') }}" class="waves-effect waves-dark sidebarCustom">
                    <i class="fa fa-handshake-o main-icon"></i>
                    Deals
                </a>
            </li>
        @endcan --}}

        {{-- @can('View|Customer')

            <li class="{{ Route::is('home.customer') ? 'sidebar-active' : '' }}">
                <a href="{{ route('home.customer') }}" class="waves-effect waves-dark sidebarCustom">
                    <i class="fa fa-address-book main-icon"></i>
                    Customer
                </a>
            </li>
        @endcan --}}


        @can('View|Role')
            <li class="{{ Route::is('home.role') ? 'sidebar-active' : '' }}">
                <a href="{{ route('home.role') }}" class="waves-effect waves-dark sidebarCustom">
                    <i class="fa fa-lock main-icon" aria-hidden="true"></i>
                    Role And Permission
                </a>
            </li>
        @endcan
        @can('View|User Management')
            <li class="{{ Route::is('user_management.index') ? 'sidebar-active' : '' }}">
                <a href="{{ route('user_management.index') }}" class="waves-effect waves-dark sidebarCustom">
                    <i class="fa fa-lock main-icon" aria-hidden="true"></i>
                    User Management
                </a>
            </li>
        @endcan
        @can('View|Settings')
        <li class="{{ Route::is('leadfiletype.index') ? 'sidebar-active' : '' }}">
            <a href="{{ route('leadfiletype.index') }}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-address-book main-icon"></i>
                Settings
            </a>
        </li>
        @endcan
        @can('View|Project Management')
            <li class="{{ Route::is('home.pm') ? 'sidebar-active' : '' }}">
                <a href="{{ route('home.pm') }}" class="waves-effect waves-dark sidebarCustom">
                    <i class="fa fa-address-book main-icon"></i>
                    Project Management
                </a>
            </li>
        @endcan


    </ul>



    {{-- <li class="{{Route::is('lead.index')?'sidebar-active':''}}">
            <a href="{{ route('lead.index') }}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-address-book main-icon"></i>
                Lead
            </a>
        </li> --}}
    {{-- <li class="{{Route::is('customer.customerindex')?'sidebar-active':''}}">
            <a href="{{ route('customer.customerindex') }}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-users main-icon"></i>
                Customer
            </a>
        </li> --}}
    {{-- <li class="{{Route::is('contract.contractindex')?'sidebar-active':''}}">
            <a href="{{ route('contract.contractindex') }}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-handshake-o main-icon"></i>
                Contracts
            </a>
        </li>
        <li class="{{Route::is('payment.paymentindex')?'sidebar-active':''}}">
            <a href="{{ route('payment.paymentindex') }}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-money main-icon"></i>
                Payment and Billing
            </a>
        </li> --}}

    {{-- <li class="{{Route::is('report.reportindex')?'sidebar-active':''}}">
            <a href="{{ route('report.reportindex') }}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-file-text main-icon"></i>
               Report
            </a>
        </li>

        <li class="{{Route::is('appointment.appointmentindex')?'sidebar-active':''}}">
            <a href="{{ route('appointment.appointmentindex') }}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-calendar main-icon"></i>
               Tasks and Appointments
            </a>
        </li>

        <li class="{{Route::is('campaign.campaignindex')?'sidebar-active':''}}">
            <a href="{{route('campaign.campaignindex')}}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-bullhorn main-icon"></i>
               Campaign
            </a>
        </li>

        <li class="{{Route::is('inventory.inventoryindex')?'sidebar-active':''}}">
            <a href="{{route('inventory.inventoryindex')}}" class="waves-effect waves-dark sidebarCustom">
                <i class="fa fa-houzz main-icon"></i>
              Innventory
            </a>
        </li> --}}

    <!-- <li data-toggle="collapse" data-target="#service" class="collapsed" data-parent="#menu-content">
        <a href="#">
          <i class="fa fa-fw fa-table fa-lg"></i>Reports
          <i class="fa fa-chevron-down"></i>
        </a>
      </li>
      <ul class="sub-menu collapse" id="service">
        <li><a href="#">Report 1</a></li>
        <li><a href="#">Report 2</a></li>
        <li><a href="#">Report 3</a></li>
      </ul> -->

    <div class="profile-details">

        <img src="{{ auth()->user()->hasMedia('profile-photo')? auth()->user()->getMedia('profile-photo')[0]->getFullUrl(): 'backend/images/avatar-1.jpg' }}"
            class="img-fluid innersection" alt="profileImg" style="border-radius:35%!important;">
        <div class="name_job">
            <div class="name">{{ auth()->user()->name }}</div>
            <i class="fa fa-sign-out" id="log_out" style="color:#999999;"></i>
        </div>
    </div>
</div>



{{-- <ul class="pcoded-item pcoded-left-item mt-3 ">

        <li>
            <a href="{{ route('company.create') }}" class="waves-effect waves-dark sidebarCustom {{Route::is('company.create')?'sidebar-active':''}}">
<span class="pcoded-micon"><i class="fa fa-globe main-icon"></i> </span>
<span class="pcoded-mtext " data-i18n="nav.basic-components.main">Company</span>
<span class="pcoded-mcaret "></span>
</a>
<ul class="pcoded-submenu">
    <li class=" ">
        <a href="{{ route('home.company') }}" class="waves-effect waves-dark {{Route::is('home.company')?'sidebar-active':''}}">
            <span class="pcoded-micon"><i class="fa fa-solid fa-laptop "></i></span>
            <span class="pcoded-mtext ">Company Configuration</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
    <li class=" ">
        <a href="{{ route('company.create') }}" class="waves-effect waves-dark">
            <span class="pcoded-micon"><i class="fa fa-solid fa-laptop "></i></span>
            <span class="pcoded-mtext ">Company Setup</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>

</ul>
</li>
</ul>
<ul class="pcoded-item pcoded-left-item">

    <li>
        <a href="{{ route('package.index') }}" class="waves-effect waves-dark sidebarCustom {{Route::is('package.index')?'sidebar-active':''}}">
            <span class="pcoded-micon"><i class="fa fa-sticky-note main-icon"></i> </span>
            <span class="pcoded-mtext " data-i18n="nav.basic-components.main">Package</span>
            <span class="pcoded-mcaret "></span>
        </a>
        <ul class="pcoded-submenu">
            <li class=" ">
                <a href="{{ route('home.package') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa fa-solid fa-laptop"></i></span>
                    <span class="pcoded-mtext ">Package Configuration</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class=" ">
                <a href="{{ route('package.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa fa-solid fa-laptop "></i></span>
                    <span class="pcoded-mtext ">View Package</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

        </ul>
    </li>
</ul>

<ul class="pcoded-item pcoded-left-item">

    <li>
        <a href="{{ route('lead.index') }}" class="waves-effect waves-dark sidebarCustom {{Route::is('lead.index')?'sidebar-active':''}}">
            <span class="pcoded-micon"><i class="fa fa-address-book main-icon"></i> </span>
            <span class="pcoded-mtext " data-i18n="nav.basic-components.main">Lead</span>
            <span class="pcoded-mcaret "></span>
        </a>
        <ul class="pcoded-submenu">
            <li class=" ">
                <a href="{{ route('home.lead') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa fa-solid fa-laptop"></i></span>
                    <span class="pcoded-mtext ">Lead Configuration</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class=" ">
                <a href="{{ route('lead.index') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa fa-solid fa-laptop "></i></span>
                    <span class="pcoded-mtext ">Lead View</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>


            <li class=" ">
                <a href="{{ route('lead.leadprofile') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa fa-solid fa-laptop "></i></span>
                    <span class="pcoded-mtext "></span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>

</ul>

<ul class="pcoded-item pcoded-left-item">

    <li>
        <a href="{{ route('customer.customerindex') }}" class="waves-effect waves-dark sidebarCustom {{Route::is('customer.customerindex')?'sidebar-active':''}}">
            <span class="pcoded-micon"><i class="fa fa-users main-icon"></i> </span>
            <span class="pcoded-mtext " data-i18n="nav.basic-components.main">Customer</span>
            <span class="pcoded-mcaret "></span>
        </a>
        <ul class="pcoded-submenu">
            <li class=" ">
                <a href="{{ route('home.customer') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa fa-solid fa-laptop"></i></span>
                    <span class="pcoded-mtext ">Customer Configuration</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class=" ">
                <a href="{{ route('customer.customerindex') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa fa-solid fa-laptop "></i></span>
                    <span class="pcoded-mtext ">View Customer</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

        </ul>
    </li>
</ul>


<ul class="pcoded-item pcoded-left-item">

    <li>
        <a href="{{ route('contract.contractindex') }}" class="waves-effect waves-dark sidebarCustom {{Route::is('contract.contractindex')?'sidebar-active':''}}">
            <span class="pcoded-micon"><i class="fa fa-handshake-o main-icon"></i> </span>
            <span class="pcoded-mtext " data-i18n="nav.basic-components.main">Contracts</span>
            <span class="pcoded-mcaret "></span>
        </a>
        <ul class="pcoded-submenu">
            <li class=" ">
                <a href="{{ route('contract.contractindex') }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="fa fa-solid fa-laptop"></i></span>
                    <span class="pcoded-mtext ">View Contract</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>


        </ul>
    </li>
</ul> --}}




{{--
    <li class="profile">
        <div class="profile-details">
            <img src="backend/images/avatar-1.jpg" class="img-fluid innersection" alt="profileImg">

            <div class="name_job" style="margin-left:30px;">
                <div class="name">User Profile</div>
                <div class="job">Web designer</div>

            </div>
        </div>
        <i class="bx bx-log-out" id="log_out"></i>
    </li> --}}
<!-- <script>
    $("pcoded-hasmenu ").click(
        function(event) {
            debugger;
            $('pcoded-hasmenu ').removeClass('active');
            $(this).addClass('active');
            event.preventDefault()
        }
    );
</script> -->
