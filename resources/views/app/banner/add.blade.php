@extends('layouts.dashboard.default')
@section('title', 'Add Banner')

@section('styles')
<style>
#add-banner {
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
                <li class="breadcrumb-item active" aria-current="page">Add Banner</li>
            </ol>
        </nav>
        <a href="{{url('/dashboard/banner')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-circle-left fa-sm text-white-50"></i> Back to Banner</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button id="add-banner" class="btn btn-success btn-sm">Add Data</button>
            <h6 class="m-0 font-weight-bold text-primary">Details Banner</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label>Banner image:</label><br>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image">
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
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $('#add-banner').on('click', function() {
        const image = $('#image')[0].files[0];

        var addedFile = new FormData();
        addedFile.append('image',image);

        // let addedProduct = {
        //     name: name.val(),
        //     quantity: quantity.val(),
        //     image: image,
        //     price: price.val(),
        //     discountPrice: discountPrice.val(),
        //     totalDiscount: totalDiscount.val(),
        // }

        $.ajax({
            type: 'POST',
            url: 'http://localhost/anterin-sayur/api/banner/create',
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

    function calc() {
        var priceVal = $('#price').val();
        var discountVal = $('#discountPrice').val();
        var totalDiscVal = parseInt(priceVal) - parseInt(discountVal);
        if (!isNaN(totalDiscVal)) {
            $('#totalDiscount').val(totalDiscVal);
        }
    }
</script>
@endsection