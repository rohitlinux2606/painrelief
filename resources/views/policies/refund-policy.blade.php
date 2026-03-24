@extends('layouts.web')

@section('title', 'Refund and Cancellation Policy – Sanjeevani Ortho Lab')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="fw-bold mb-4">Refund and Cancellation Policy</h1>
                        <p class="text-muted mb-4">Last Updated: {{ date('F d, Y') }}</p>

                        <p>At <strong>Sanjeevani Ortho Lab</strong>, we take pride in the quality of our Ayurvedic products.
                            If you are not entirely satisfied with your purchase, or if you need to cancel your order, we're
                            here to help.</p>

                        <h3 class="fw-bold mt-5 mb-3">1. Order Cancellation</h3>
                        <p>You may request a cancellation of your order under the following conditions:</p>
                        <ul>
                            <li><strong>Before Dispatch:</strong> You can cancel your order anytime before it has been
                                dispatched from our facility. A full refund will be initiated immediately.</li>
                            <li><strong>After Dispatch:</strong> Once an order is handed over to our shipping partner, it
                                cannot be canceled. In such cases, please refer to our Return Policy.</li>
                        </ul>
                        <p>To request a cancellation, please email us immediately at <a
                                href="mailto:orthosanjeevanilab@gmail.com">orthosanjeevanilab@gmail.com</a> with your
                            Order ID.</p>

                        <h3 class="fw-bold mt-5 mb-3">2. Eligibility for Refunds</h3>
                        <p>Refunds for returned products are only processed under the following conditions:</p>
                        <ul>
                            <li>The product was damaged during transit.</li>
                            <li>The product received is expired or deficient.</li>
                            <li>The wrong product was delivered.</li>
                        </ul>

                        <h3 class="fw-bold mt-5 mb-3">3. Refund Process</h3>
                        <p>To initiate a refund for a return, please contact us at <a
                                href="mailto:orthosanjeevanilab@gmail.com">orthosanjeevanilab@gmail.com</a> within 48
                            hours
                            of receiving your order. You will be required to provide proof of damage or error (e.g.,
                            photographs).</p>

                        <h3 class="fw-bold mt-5 mb-3">4. Approval of Refunds</h3>
                        <p>Once your return/refund request is received and inspected (or your cancellation is confirmed), we
                            will notify you of the approval or rejection. If approved, your refund will be processed, and a
                            credit will automatically be
                            applied to your original method of payment within 7–10 business days.</p>

                        <h3 class="fw-bold mt-5 mb-3">5. Non-Refundable Items</h3>
                        <p>Please note that used products or products with broken seals are not eligible for refunds due to
                            wellness and safety reasons.</p>

                        <h3 class="fw-bold mt-5 mb-3">6. Late or Missing Refunds</h3>
                        <p>If you haven't received a refund yet, first check your bank account again. Then contact your
                            credit card company or bank, as it may take some time before your refund is officially posted.
                            If you've done all of this and still have not received your refund, please contact us.</p>

                        <h3 class="fw-bold mt-5 mb-3">7. Contact Us</h3>
                        <p>For any questions regarding our Refund and Cancellation Policy, please reach out to:</p>
                        <p>
                            <strong>Sanjeevani Ortho Lab</strong><br>
                            Email: <a href="mailto:orthosanjeevanilab@gmail.com">orthosanjeevanilab@gmail.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
