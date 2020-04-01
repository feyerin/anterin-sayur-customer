@extends('layouts.dashboard.default')
@section('title', 'Detail Banner')

@section('styles')
<style>
#edit-banner {
    float: right;
}
#save-banner {
    display: none;
    float: right;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard/banner')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Banner</li>
            </ol>
        </nav>
        <a href="{{url('/dashboard/banner')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-circle-left fa-sm text-white-50"></i> Back to Banner</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                <button id="edit-banner" class="btn btn-primary btn-sm">Edit Data</button>
                <button id="save-banner" class="btn btn-primary btn-sm">Save Data</button>
            <h6 class="m-0 font-weight-bold text-primary">Detail Banner</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                        <label for="id">Banner ID:</label><br>
                        <input type="text" id="id" name="id" class="form-control" disabled><br>
                </div>
                <div class="col-lg-6 col-md-6">
                        <label>Banner image:</label><br>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" disabled>
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$( document ).ready(function() {
    getAPIBanner();
});

function getAPIBanner() {
    const url = window.location.href;
    const urlParams = url.split("/");
    const bannerId = urlParams[6];

    $.ajax({
        type: 'GET',
        url: 'http://localhost/anterin-sayur/api/banner/read/' + bannerId,
        success: function (data) {
            const bannerData = data.data;
            $('#id').val(bannerData.id);
            $('#image').html(bannerData.image);
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}
</script>

<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $('#edit-banner').on('click', function() {
        $('#edit-banner').css('display','none');
        $('#save-banner').css('display','block');
        $('#save-banner').removeClass('btn-primary');
        $('#save-banner').addClass('btn-success');

        $('#image').prop('disabled', false);
    });

    $('#save-banner').on('click', function() {
        const id = $('#id').val();
        const image = $('#image')[0].files[0];

        var addedFile = new FormData();
        addedFile.append('bannerId',id);
        addedFile.append('image',image);

        $.ajax({
            type: 'POST',
            url: 'http://localhost/anterin-sayur/api/banner/update',
            data: addedFile,
            contentType: false,
            processData: false,
            success: function (data) {
                // alert("Success");
                window.location.href="http://localhost/anterin-sayur/dashboard/banner";
            },
            timeout: 300000,
            error: function (e) {
                console.log(e);
            }
        });
    });
</script>
@endsection