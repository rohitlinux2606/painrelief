@extends('layouts.web')

@section('title', 'Contact Us – Sanjeevani Ortho Lab')

@section('content')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="fw-bold">Contact Us</h1>
                    <p class="text-muted">We'd love to hear from you. Reach out to us for any queries.</p>
                </div>

                <div class="card shadow border-0">
                    <div class="card-body p-4 p-md-5">

                        <div class="mb-5">
                            <h4 class="fw-bold mb-3">Business Information</h4>
                            <div class="d-flex mb-3">
                                <div class="me-3 text-success fs-4"><i class="bi bi-building"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Business Information</h6>
                                    <p class="mb-0 text-muted">Sanjeevani Ortho Lab</p>
                                </div>
                            </div>

                            <div class="d-flex mb-3">
                                <div class="me-3 text-success fs-4"><i class="bi bi-geo-alt"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Registered Address</h6>
                                    <p class="mb-0 text-muted">
                                        Building No./Flat No.: HANUMANT PALACE INDORE, BLOCK-C,<br>
                                        Road/Street: 2-A,<br>
                                        City/Town/Village: Indore,<br>
                                        District: Indore,<br>
                                        State: Madhya Pradesh,<br>
                                        PIN Code: 452002
                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-4">
                            <h4 class="fw-bold mb-3">Get in Touch</h4>

                            <div class="d-flex mb-3 align-items-center">
                                <div class="me-3 text-primary fs-4"><i class="bi bi-envelope"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Email Us</h6>
                                    <a href="mailto:orthosanjeevanilab@gmail.com"
                                        class="text-decoration-none text-muted">orthosanjeevanilab@gmail.com</a>
                                </div>
                            </div>

                            <div class="d-flex mb-3 align-items-center">
                                <div class="me-3 text-primary fs-4"><i class="bi bi-telephone"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Call Us</h6>
                                    <a href="tel:+919691905073" class="text-decoration-none text-muted">+91 96919 05073</a>
                                </div>
                            </div>

                            <div class="d-flex mb-3 align-items-center">
                                <div class="me-3 text-success fs-4"><i class="bi bi-whatsapp"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">WhatsApp Support</h6>
                                    <a href="https://wa.me/919691905073" target="_blank"
                                        class="text-decoration-none text-muted">Chat with us</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Optional Map Embed (Placeholder) -->
                {{-- <div class="mt-5 rounded overflow-hidden shadow-sm">
                <iframe src="https://www.google.com/maps/embed?..." width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div> --}}

            </div>
        </div>
    </div>

@endsection
