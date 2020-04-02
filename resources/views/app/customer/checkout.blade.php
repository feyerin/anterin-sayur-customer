@extends('layouts.web.order')
@section('title', 'Checkout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-7 ftco-animate">
            <form action="#" class="billing-form">
                <h3 class="mb-4 billing-heading">Billing Details</h3>
                <div class="row align-items-end">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input id="name" type="text" class="form-control" placeholder="Your full name">
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input id="phone" type="text" class="form-control" placeholder="Your phone number">
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input id="email" type="text" class="form-control" placeholder="Your email address">
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="streetaddress">Street Address</label>
                            <input id="address" type="text" class="form-control" placeholder="House number and street name">
                        </div>
                    </div>
                </div>
            </form><!-- END -->
        </div>
        <div class="col-xl-5">
            <div class="row mt-5 pt-3">
                <div class="col-md-12 d-flex mb-5">
                    <div class="cart-detail cart-total p-3 p-md-4">
                        <h3 class="billing-heading mb-4">Cart Total</h3>
                        <p class="d-flex">
                            <span>Subtotal</span>
                            <span id="totalPrice"></span>
                        </p>
                        <p class="d-flex">
                            <span>Delivery</span>
                            <span>Free</span>
                        </p>
                        <p class="d-flex">
                            <span>Discount</span>
                            <span id="totalDiscount"></span>
                        </p>
                        <hr>
                        <p class="d-flex total-price">
                            <span>Total</span>
                            <span id="totalPayment"></span>
                        </p>
                    </div>
                </div>
            </div>
            <p><a class="btn btn-primary py-3 px-4" style="color: black !important" onclick="setUserData();">Place an order</a></p>
        </div> <!-- .col-md-8 -->
    </div>
</div>
@endsection

@section('scripts')
<script>
$( document ).ready(function() {
    getAPICart();
});

function getAPICart() {
    const url = window.location.href;
    const urlParams = url.split("/");
    const orderId = urlParams[6];
    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' });

    $.ajax({
        type: 'GET',
        url: 'http://localhost/anterin-sayur-customer/api/order/read/'+orderId,
        beforeSend: function () {},
        success: function (data) {
            const cartData = data.data.order;
            const totalPrice = formatter.format(cartData.totalPrice);
            const totalDiscount = formatter.format(cartData.totalDiscount);
            const totalPayment = formatter.format(cartData.totalPayment);

            $('#totalPrice').html(totalPrice);
            $('#totalDiscount').html(totalDiscount);
            $('#totalPayment').html(totalPayment);
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}

function setUserData() {
    const url = window.location.href;
    const urlParams = url.split("/");
    const orderId = urlParams[6];
    
    const name = $('#name').val();
    const phone = $('#phone').val();
    const address = $('#address').val();
    const email = $('#email').val();

    var userData = new FormData();
    userData.append('orderId', orderId);
    userData.append('name', name);
    userData.append('phone', phone);
    userData.append('address', address);
    userData.append('email', email);

    $.ajax({
        type: 'POST',
        url: 'http://localhost/anterin-sayur-customer/api/order/set-user-data',
        data: userData,
        contentType: false,
        processData: false,
        success: function (data) {
            window.location.href="http://localhost/anterin-sayur-customer/web/confirmation";
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}
</script>
@endsection