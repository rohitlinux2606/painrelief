<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Vatahari</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --border-color: #e6e6e6;
            --text-light: #707070;
            --bg-summary: #fafafa;
        }

        body {
            background-color: #fff;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #333;
        }

        /* Navbar */
        .navbar {
            border-bottom: 1px solid var(--border-color);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1.5px;
            font-size: 1.25rem;
        }

        /* Layout Structure */
        .main-wrapper {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* Left Column (Forms) */
        .form-section {
            padding: 40px 20px 40px 0;
        }

        /* Right Column (Summary) */
        .summary-section {
            background-color: var(--bg-summary);
            border-left: 1px solid var(--border-color);
            padding: 40px 0 40px 40px;
            min-height: 100vh;
        }

        /* Form Inputs */
        .form-label-custom {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .shopify-input {
            border: 1px solid var(--border-color) !important;
            border-radius: 5px !important;
            padding: 10px 12px !important;
            font-size: 0.9rem !important;
            box-shadow: none !important;
        }

        .shopify-input:focus {
            border-color: #000 !important;
            outline: 1px solid #000;
        }

        /* Buttons */
        .btn-continue {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 15px 25px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 0.9rem;
            width: auto;
            float: right;
        }

        /* Summary Elements */
        .product-img-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: #fff;
            position: relative;
        }

        .img-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #666;
            color: #fff;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        @media (max-width: 768px) {
            .form-section {
                padding: 20px;
            }

            .summary-section {
                padding: 20px;
                border-left: none;
                border-bottom: 1px solid var(--border-color);
                order: -1;
                min-height: auto;
            }

            .btn-continue {
                width: 100%;
                float: none;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container main-wrapper px-3 px-lg-0">
            <a class="navbar-brand mx-auto mx-lg-0" href="#">VATAHARI</a>
            <div class="d-none d-lg-block">
                <small class="me-3">Home</small>
                <small>Catalog</small>
            </div>
        </div>
    </nav>

    <div class="main-wrapper">
        <div class="row g-0">
            <div class="col-lg-7 form-section">
                <nav style="--bs-breadcrumb-divider: '›';" aria-label="breadcrumb">
                    <ol class="breadcrumb small mb-4">
                        <li class="breadcrumb-item"><a href="#" class="text-dark text-decoration-none">Cart</a>
                        </li>
                        <li class="breadcrumb-item active fw-bold">Information</li>
                        <li class="breadcrumb-item text-muted">Shipping</li>
                        <li class="breadcrumb-item text-muted">Payment</li>
                    </ol>
                </nav>

                <form>
                    <div class="d-flex justify-content-between align-items-end mb-2">
                        <span class="form-label-custom mb-0">Contact</span>
                        <small class="small">Have an account? <a href="#" class="text-dark">Log in</a></small>
                    </div>
                    <div class="mb-4">
                        <input type="text" class="form-control shopify-input"
                            placeholder="Email or mobile phone number">
                    </div>

                    <span class="form-label-custom">Shipping Address</span>
                    <div class="row g-2">
                        <div class="col-12">
                            <select class="form-select shopify-input">
                                <option>India</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control shopify-input"
                                placeholder="First name (optional)">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control shopify-input" placeholder="Last name">
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control shopify-input" placeholder="Address">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control shopify-input" placeholder="City">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select shopify-input">
                                <option selected>State</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control shopify-input" placeholder="PIN code">
                        </div>
                    </div>

                    <div class="mt-5 d-flex justify-content-between align-items-center">
                        <a href="#" class="text-dark text-decoration-none small"><i
                                class="bi bi-chevron-left"></i> Return to cart</a>
                        <button class="btn btn-continue">Continue to shipping</button>
                    </div>
                </form>

                <div class="mt-5 pt-4 border-top">
                    <small class="text-muted me-3">Refund policy</small>
                    <small class="text-muted">Privacy policy</small>
                </div>
            </div>

            <div class="col-lg-5 summary-section">
                <div class="d-flex align-items-center mb-4">
                    <div class="product-img-wrapper">
                        <img src="https://via.placeholder.com/64" class="w-100 h-100 rounded" alt="Product">
                        <span class="img-badge">1</span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="small mb-0 fw-bold">Vatahari Vati - Natural Relief</h6>
                        <small class="text-muted">60 Tablets</small>
                    </div>
                    <div class="text-end small fw-bold">Rs. 630.00</div>
                </div>

                <div class="d-flex gap-2 mb-4 border-top pt-4">
                    <input type="text" class="form-control shopify-input" placeholder="Discount code">
                    <button class="btn btn-light border px-3 small">Apply</button>
                </div>

                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">Rs. 630.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-muted">Shipping</span>
                        <span class="text-muted">Calculated at next step</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <h5 class="fw-bold mb-0">Total</h5>
                        <h4 class="fw-bold mb-0">Rs. 630.00</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
