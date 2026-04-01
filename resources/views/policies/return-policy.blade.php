@extends('layouts.web')

@section('title', 'Return Policy – Sanjeevani Ortho Lab')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="fw-bold mb-4">Return Policy</h1>
                        <p class="text-muted mb-4">Last Updated: {{ date('F d, Y') }}</p>

                        <p>At <strong>Sanjeevani Ortho Lab</strong> (operating under the brand <strong>Vatahari</strong>),
                            we want you to be completely satisfied with your
                            purchase. Our return policy is designed to be fair and transparent.</p>

                        <h3 class="fw-bold mt-5 mb-3">1. Return Window</h3>
                        <p>You have 7 days from the date of delivery to request a return if the product is damaged,
                            incorrect, or defective.</p>

                        <h3 class="fw-bold mt-5 mb-3">2. Conditions for Returns</h3>
                        <p>To be eligible for a return:</p>
                        <ul>
                            <li>The product must be in its original packaging.</li>
                            <li>The seal must not be broken (except for quality issues detected upon opening).</li>
                            <li>You must have the receipt or proof of purchase.</li>
                        </ul>

                        <h3 class="fw-bold mt-5 mb-3">3. Exempt Items</h3>
                        <p>Standard items, personalized items, or used wellness supplements cannot be returned due to
                            wellness and safety protocols.</p>

                        <h3 class="fw-bold mt-5 mb-3">4. Return Shipping</h3>
                        <p>If the return is due to our error (damaged or wrong product), we will arrange for a pickup or
                            reimburse the shipping costs. For all other returns, you will be responsible for paying for your
                            own shipping costs for returning your item.</p>

                        <h3 class="fw-bold mt-5 mb-3">5. Exchanges</h3>
                        <p>We only replace items if they are defective or damaged. If you need to exchange it for the same
                            item, send us an email at <a
                                href="mailto:orthosanjeevanilab@gmail.com">orthosanjeevanilab@gmail.com</a>.</p>

                        <h3 class="fw-bold mt-5 mb-3">6. Process</h3>
                        <p>To start a return, please contact our support team. Once your return is received and inspected,
                            we will notify you and process your refund or exchange accordingly.</p>

                        <h3 class="fw-bold mt-5 mb-3">7. Contact Information</h3>
                        <p>If you have any questions on how to return your item to us, contact us:</p>
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
