@extends('layouts.dashboard.default')
@section('title', 'Banner')

@section('styles')
<link href="{{asset('public/templates/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Banners</h1>
        <a href="{{url('banner/add')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Add Banner</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Banners Tables</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-banner" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Banner ID</th>
                            <th>Banner Name</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Banner ID</th>
                            <th>Banner Name</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('public/templates/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/templates/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.bootstrap.min.js"></script>

<script>
$( document ).ready(function() {
    tableBanner();
});

function tableBanner() {
    
    var table = $('#table-banner').DataTable({
        "dom": 'Bfrtip',
        "buttons": [
            {
                text: 'Detail',
                className: 'btn btn-warning',
                action: function () {
                    let dataTable = table.rows( { selected: true } ).data();
                    let bannerId = dataTable[0].id;

                    window.location.href="{{url('banner/detail')}}/"+bannerId;
                }
            },
            {
                text: 'Delete',
                className: 'btn btn-danger',
                action: function () {
                    let dataTable = table.rows( { selected: true } ).data();
                    let bannerId = dataTable[0].id;

                    deleteBanner(bannerId);
                }
            }
        ],
        "select": {
            style: 'single'
        },
        "ajax": {
            "url": 'http://localhost/anterin-sayur/api/banner',
            "type": 'GET'
        },
        "columns": [
            { "data": "id" },
            { "data": "image" }
        ],
    });
}

function deleteBanner(data) {
    let deletedBanner = {
        bannerId: data,
    }

    $.ajax({
        type: 'POST',
        data: deletedBanner,
        url: 'http://localhost/anterin-sayur/api/banner/delete',
        success: function (data) {
            location.reload();
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}
</script>
@endsection