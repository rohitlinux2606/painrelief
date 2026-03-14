@extends('layouts.app')

@section('title', 'Shipping & Return Policy - Vatahari')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="fw-bold mb-4">Shipping & Return Policy</h1>
            <p class="text-muted mb-4">Last Updated: {{ date('F j, Y') }}</p>

            <div class="content">
                <h3 class="fw-bold mt-4 mb-3">Shipping Policy</h3>
                
                <h5 class="fw-bold mt-4">Processing Time</h5>
                <p>All orders are processed within 1-2 business days. Orders are not shipped or delivered on weekends or holidays.</p>

                <h5 class="fw-bold mt-4">Shipping Rates & Delivery Estimates</h5>
                <p>Shipping charges for your order will be calculated and displayed at checkout. Delivery delays can occasionally occur depending on the destination and courier services.</p>

                <h5 class="fw-bold mt-4">Shipment Confirmation & Order Tracking</h5>
                <p>You will receive a Shipment Confirmation email once your order has shipped containing your tracking number(s). The tracking number will be active within 24 hours.</p>

                <hr class="my-5">

                <h3 class="fw-bold mb-3">Return Policy</h3>

                <h5 class="fw-bold mt-4">Returns</h5>
                <p>We accept returns within 7 days of delivery. To be eligible for a return, your item must be unused, in the same condition that you received it, and in its original packaging.</p>

                <h5 class="fw-bold mt-4">Refunds</h5>
                <p>Once we receive your returned item, we will inspect it and notify you. If your return is approved, we will initiate a refund to your original method of payment within 5-7 business days.</p>

                <h5 class="fw-bold mt-4">Non-Returnable Items</h5>
                <p>Certain types of items cannot be returned, including opened or used wellness products, for hygiene and safety reasons.</p>

                <h5 class="fw-bold mt-4">Contact Us</h5>
                <p>If you have any questions on how to return your item to us, contact us at orthosanjeevanilab@gmail.com.</p>
            </div>
        </div>
    </div>
</div>
@endsection
