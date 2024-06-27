@extends('backend.layouts.app')
<style>
    .header-box {
        background-color: #0065a0;
        margin-bottom: 12px;
        border-radius: 4px;
        padding: 5px;
    }

    .header h4 {
        color: white;
        font-size: 15px;
        font-weight: 300;
    }

    .btn-primary {
        background: #0065a0 !important;
    }
</style>
@section('content')
    <div class="container card p-3">
        <form action="" method="POST" id="form" enctype="multipart/form-data">
            @csrf
            <div class="header-box mt-1">
                <div class="header">
                    <h4>User Setup</h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mt-1">
                                <h4
                                    style="color: #0065a0;
                                font-size: 14px;
                                font-weight: 500;">
                                    First Name : </h4>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" name="first_name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mt-1">
                                <h4
                                    style="color: #0065a0;
                                font-size: 14px;
                                font-weight: 500;">
                                    Middle Name : </h4>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" name="middle_name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mt-1">
                                <h4
                                    style="color: #0065a0;
                                font-size: 14px;
                                font-weight: 500;">
                                    Last Name : </h4>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" name="last_name" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">

                </div>
            </div>

            <div class="form-group">
                <a class="btn btn-primary text-white" onclick="submit()">Submit</a>
            </div>
        </form>
    </div>
@endsection

<script>
    function submit() {
        var formData = new FormData();
        formData.append('data',
            JSON.stringify({
                label: "seo",
                keywords: tags,
                meta_title: metaTitle,
                meta_description: metaDescription
            }));
    }
</script>
