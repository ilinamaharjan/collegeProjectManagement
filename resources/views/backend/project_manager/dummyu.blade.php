<div class="col-md-12">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <a href="/taskprofile/${task.id}">
                <h5 class="lead-ti">${ task.name }</h5>
            </a>
        </div>

        <div class="col-md-6">
            <div class="menu-nav" style="float:right;">
                <div class="dropdown-container" tabindex="-1" style="float:right;">
                    <div class="three-dots"></div>
                    <div class="dropdown">
                        <a href="#">
                            <div class="activity-dot">Cancel</div>
                        </a>
                        <a href="#">
                            <div class="activity-dot">Halt</div>
                        </a>
                        <a href="#">
                            <div class="activity-dot">Add Handler</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<div class="d-flex bd-highlight mt-3 p-3">
    <div class="flex-fill bd-highlight">

        <span class="input-group-text"
            style="background-color:transparent!important; border:none!important; padding:0px;">
            <i class="fa fa-calendar deal"> ${task.created_at.split('T')[0]}</i>
    </div>

</div>
