@extends('layouts.web.order')
@section('title', 'Thank you for buying')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url({{url('public/templates/web/images/about.jpg')}});"></div>
        <div class="col-md-7 py-5 wrap-about pb-md-5 ftco-animate">
            <div class="heading-section-bold mb-4 mt-md-5">
                <div class="ml-md-0">
                    <h2 class="mb-4">Thank's for buying using Anterin-Sayur</h2>
                </div>
            </div>
            <div class="pb-md-5">
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                <p>But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
                <p>
                    <a href='https://api.whatsapp.com/send?phone=6281321678718&text=Saya20%ingin20%konfirmassi20%pembayaran20%untuk20%order20%".$order->orderCode."' class="btn btn-primary">
                        Payment Confirmation
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection