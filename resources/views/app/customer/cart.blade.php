@extends('layouts.web.order')
@section('title', 'Your Cart')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-3 pb-3">
        <div class="col-md-12 heading-section text-center ftco-animate">
            <div class="cart-list">
                <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>Product name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="list-order">

                        </tbody>
                </table>
            </div>
        </div>
    </div> 
    <div class="row justify-content-center">
        <div class="col-lg-4 mt-5 cart-wrap ftco-animate">
            <div class="cart-total mb-3">
                <h3>Cart Totals</h3>
                <p class="d-flex">
                    <span>Subtotal</span>
                    <span id="sub-total"></span>
                </p>
                <p class="d-flex">
                    <span>Delivery</span>
                    <span>Free</span>
                </p>
                <hr>
                <p class="d-flex total-price">
                    <span>Total</span>
                    <span id="total"></span>
                </p>
            </div>
            <p><a id="checkout" class="btn btn-primary py-3 px-4" onclick="checkout();" style="color: black !important">Proceed to Checkout</a></p>
        </div>
    </div>  		
</div>
@endsection

@section('scripts')
<script>
$( document ).ready(function() {
    getAPICart();
});

function getAPICart() {
    $.ajax({
        type: 'GET',
        url: 'http://localhost/anterin-sayur/api/order/get-cart',
        beforeSend: function () {},
        success: function (data) {
            displayCart(data);
            console.log(data.data.orderProduct);
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}

function displayCart(data) {
    const orderProduct = data.data.orderProduct;
    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' });
    const url = 'url("http://localhost/anterin-sayur/';

    let markup,
        index = 0,
        subTotal = 0;

    var productImage,
        productName,
        productQuantity,
        productPrice,
        totalPrice,
        totalDiscount,
        totalDiscountPrice,
        tempPrice;

    for(index in orderProduct) {
        productImage = orderProduct[index].productImage;
        productName = orderProduct[index].productName;
        productQuantity = orderProduct[index].quantity;
        productPrice = orderProduct[index].price;
        totalPrice = orderProduct[index].totalPrice;
        totalDiscount = orderProduct[index].totalDiscount;
        totalDiscountPrice = orderProduct[index].totalDiscountPrice;

        formattedPrice = formatter.format(totalPrice);
        formattedTotalDiscount = formatter.format(totalDiscount);
        formattedTotalDiscountPrice = formatter.format(totalDiscountPrice);
        tempPrice = parseInt(totalDiscount);

        subTotal = subTotal + tempPrice;

        markup = `
                    <tr class="text-center">
                        <td class="product-remove"><a href="#"><span class="ion-ios-close"></span></a></td>
                        <td class="image-prod"><div class="img" style="background-image:url({{url('public/` + productImage + `')}})"></div></td>
                        <td class="product-name">
                            <h3>` + productName + `</h3>
                        </td>
                        <td class="quantity">
                            <span>` + productQuantity + `</span>
                        </td>
                        <td class="price">` + formattedPrice + `</td>
                        <td class="price">` + formattedTotalDiscountPrice + `</td>
                        <td class="total">` + formattedTotalDiscount + `</td>
                    </tr><!-- END TR-->
                `;
                
        $('#list-order').append(markup);
    }
    $('#sub-total').html(formatter.format(subTotal))
    $('#total').html(formatter.format(subTotal))
}

function checkout() {
    $.ajax({
        type: 'GET',
        url: 'http://localhost/anterin-sayur/api/order/checkout',
        beforeSend: function () {},
        success: function (data) {
            orderId = data.params.orderId;
            window.location.href="http://localhost/anterin-sayur/web/checkout/"+orderId;
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}
</script>
@endsection