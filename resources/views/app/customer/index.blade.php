@extends('layouts.web.default')
@section('title', 'Anterin Sayur')

@section('styles')
<style>
.pagination {
    justify-content: center;
}

.pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
}

.page-indicator {
    color: black;
    padding: 8px 00px;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center mb-3 pb-3">
        <div class="col-md-12 heading-section text-center ftco-animate">
            <span class="subheading">Featured Products</span>
            <h2 class="mb-4">Our Products</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
        </div>
    </div>   		
</div>
<div class="container">
    <div id="list-product" class="row">

    </div>
    <div class="pagination" id="page">
        
    </div>
</div>
@endsection

@section('scripts')
<script>
$( document ).ready(function() {
    loadProduct();
});

function loadProduct() {
    const url = window.location.href;
    const urlParams = url.split("/");
    var page = urlParams[urlParams.length - 1];

    if(page) {
        getAPIProduct(page);
    } else {
        page = 1; // Default value page
        getAPIProduct(page);
    }
}

function getAPIProduct(data) {
    const limit = 8; // Default value item per page

    $.ajax({
        type: 'GET',
        url: "{{url('api/all-product')}}/" + data + "/" + limit,
        beforeSend: function () {},
        success: function (data) {
            displayProduct(data);
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}

function displayProduct(data) {
    const product = data.data;
    const currentPage = parseInt(data.params.page);
    const totalPage = data.params.totalPage;
    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' });

    let markup,
        markupPage,
        index = 0;
    let productId,
        productName,
        productStock,
        productImage,
        productPrice,
        productDiscount,
        productTotalDiscount;

    for(index in product) {
        if(index<8) {
            productId = product[index].id;
            productName = product[index].name;
            productStock = product[index].quantity;
            productImage = product[index].imageurl;
            productPrice = product[index].price;
            productDiscount = product[index].discountPrice;
            productTotalDiscount = product[index].totalDiscount;

            formattedPrice = formatter.format(productPrice);
            formattedTotalDiscount = formatter.format(productTotalDiscount);

            markup = `
                    <div class="col-md-6 col-lg-3">
                        <div class="product">
                            <a href="web/product/detail/` + productId + `" class="img-prod"><img class="img-fluid" src="public/` + productImage + `" alt="Colorlib Template">
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 pb-4 px-3 text-center"><h3><a href="#">` + productName + `</a></h3>
                                <div class="d-flex">
                                    <div class="pricing">
                                        <p class="price"><span class="mr-2 price-dc">` + formattedPrice + `</span><span class="price-sale">` + formattedTotalDiscount + `</span></p>
                                    </div>
                                </div>
                                <div class="bottom-area d-flex px-3">
                                    <div class="m-auto d-flex">
                                        <a href="web/product/detail/` + productId + `" class="buy-now d-flex justify-content-center align-items-center mx-1">
                                            <span><i class="ion-ios-cart"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;

            $('#list-product').append(markup);
        }
    }
    
    if(currentPage == 1) {
        markupPage = `<span class="page-indicator">Page `+ currentPage +` of `+ totalPage +` | </span><a href="{{url('/`+ (currentPage + 1) +`')}}">Next</a>`;
        $('#page').append(markupPage);
    } else {
        markupPage = `
                    <a href="{{url('/`+ (currentPage - 1) +`')}}" id="prevPage">Previous</a><span class="page-indicator"> | Page `+ currentPage +` of `+ totalPage +` | </span>
                    <a href="{{url('/`+ (currentPage + 1) +`')}}">Next</a>
                `;
        $('#page').append(markupPage);
    }
}
</script>
@endsection