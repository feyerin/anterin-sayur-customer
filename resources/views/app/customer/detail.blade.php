@extends('layouts.web.default')
@section('title', 'Anterin Sayur')

@section('styles')
<style>

</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 mb-5 ftco-animate">
            <img src="" class="img-fluid" alt="Colorlib Template" id="product-image">
        </div>
        <div class="col-lg-6 product-details pl-md-5 ftco-animate">
            <h3 id="product-name"></h3><span id="product-id" style="display: none"></span>
                <p class="price"><span id="product-price"></span><br>
                <span class="price-sale" id="product-discount-price"></span></p>
            <div class="row mt-4">
                <div class="input-group col-md-6 d-flex mb-3">
                    <span class="input-group-btn mr-2">
                        <button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
                            <i class="ion-ios-remove"></i>
                        </button>
                    </span>
                    <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
                    <span class="input-group-btn ml-2">
                        <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                            <i class="ion-ios-add"></i>
                        </button>
                    </span>
                </div>
            </div>
            <p><a href="{{url('web/cart')}}" class="btn btn-black py-3 px-5" id="add-to-cart">Add to Cart</a></p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$( document ).ready(function() {
    getAPIProduct();
    count();
});

function getAPIProduct() {
    const url = window.location.href;
    const urlParams = url.split("/");
    const productId = urlParams[7];
    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' });

    $.ajax({
        type: 'GET',
        url: 'http://localhost/anterin-sayur/api/product/read/' + productId,
        success: function (data) {
            const productData = data.data;
            const productImage = JSON.stringify(productData.image);
            const formattedPrice = formatter.format(productData.price);

            if(productData.totalDiscount !== null) {
                const formattedTotalDiscount = formatter.format(productData.totalDiscount);
                $('#product-price').css('font-size','20px');
                $('#product-price').css('text-decoration','line-through');
                $('#product-price').css('color','#b3b3b3');
                $('#product-discount-price').html(formattedTotalDiscount);
            }

            $('#product-id').html(productData.id);
            $('#product-name').html(productData.name);
            $('#product-price').html(formattedPrice);
            $('#product-image').attr('src','http://localhost/anterin-sayur/public/'+productData.image);
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}

function count() {
    var quantitiy = 0;

    $('.quantity-right-plus').click(function(e){
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());

        $('#quantity').val(quantity + 1);
    });

    $('.quantity-left-minus').click(function(e){
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        
        if(quantity>0){
            $('#quantity').val(quantity - 1);
        }
    });
}

$('#add-to-cart').on('click', function() {
    const id = $('#product-id').text();
    const quantity = $('#quantity').val();

    var addedProduct = new FormData();
    addedProduct.append('productId',id);
    addedProduct.append('quantity',quantity);

    $.ajax({
        type: 'POST',
        url: 'http://localhost/anterin-sayur/api/order/add-to-cart',
        data: addedProduct,
        contentType: false,
        processData: false,
        success: function (data) {
            // alert("Success");
            // window.location.href="dashboard";
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
});
</script>
@endsection