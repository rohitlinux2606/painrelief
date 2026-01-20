@extends('admin.layouts.app')

@push('styles')
    <style>
        .form-section-title {
            position: relative;
            padding-left: 15px;
            color: #495057;
            border-left: 4px solid #696cff;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row align-items-center mb-4 g-3">
            <div class="col-sm-6">
                <h4 class="fw-bold mb-0">
                    <span class="text-muted fw-light">Orders /</span> Create New Order
                </h4>
            </div>
            <div class="col-sm-6 text-sm-end">
                <a href="{{ route('admin.order-control.order.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
        </div>

        <form action="{{ route('admin.order-control.order.store') }}" method="POST">
            @csrf
            @include('admin.layouts.messages')

            <div class="row">
                <div class="col-lg-8">

                    {{-- CUSTOMER --}}
                    <div class="card mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Customer & Address</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Customer *</label>
                                    <select name="customer_id" id="customerSelect" class="form-select" required>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->full_name }} ({{ $customer->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Address *</label>
                                    <select name="address_id" id="addressSelect" class="form-select" required>
                                        <option value="">Select Address</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ITEMS --}}
                    <div class="card mb-4">
                        <div class="card-header bg-transparent py-3 d-flex justify-content-between">
                            <h5 class="form-section-title fw-bold mb-0">Order Items</h5>
                            <button type="button" id="addRow" class="btn btn-sm btn-primary">+ Add Item</button>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered mb-0" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th width="120">Price</th>
                                        <th width="120">Qty</th>
                                        <th width="150">Total</th>
                                        <th width="60"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="items[0][product_id]" class="form-select product-select" required>
                                                <option value="">Select</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                        data-title="{{ $product->title }}">
                                                        {{ $product->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="items[0][title]" class="item-title">
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" name="items[0][price]"
                                                class="form-control price" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][quantity]" class="form-control qty"
                                                value="1" min="1">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control row-total" readonly>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger removeRow">X</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                {{-- TOTAL --}}
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-transparent py-3">
                            <h5 class="form-section-title fw-bold mb-0">Totals</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label>Subtotal</label>
                                <input type="number" name="subtotal" id="subtotal" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <label>Tax</label>
                                <input type="number" step="0.01" name="tax" id="tax" class="form-control"
                                    value="0">
                            </div>

                            <div class="mb-3">
                                <label>Shipping</label>
                                <input type="number" step="0.01" name="shipping" id="shipping" class="form-control"
                                    value="0">
                            </div>

                            <div class="mb-3">
                                <label>Grand Total</label>
                                <input type="number" name="total" id="grandTotal" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-select">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Payment Status</label>
                                <select name="payment_status" class="form-select">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Payment Method</label>
                                <input type="text" name="payment_method" class="form-control">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-5">
                <hr>
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                    Create Order
                </button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    <script>
        let rowIndex = 1;

        function recalc() {
            let subtotal = 0;

            document.querySelectorAll('#itemsTable tbody tr').forEach(row => {
                let price = parseFloat(row.querySelector('.price').value) || 0;
                let qty = parseInt(row.querySelector('.qty').value) || 0;
                let total = price * qty;

                row.querySelector('.row-total').value = total.toFixed(2);
                subtotal += total;
            });

            document.getElementById('subtotal').value = subtotal.toFixed(2);

            let tax = parseFloat(document.getElementById('tax').value) || 0;
            let shipping = parseFloat(document.getElementById('shipping').value) || 0;

            let grand = subtotal + tax + shipping;
            document.getElementById('grandTotal').value = grand.toFixed(2);
        }

        document.addEventListener('change', function(e) {

            if (e.target.classList.contains('product-select')) {
                let row = e.target.closest('tr');
                let price = e.target.selectedOptions[0].dataset.price || 0;
                let title = e.target.selectedOptions[0].dataset.title || '';

                row.querySelector('.price').value = price;
                row.querySelector('.item-title').value = title;

                recalc();
            }

            if (e.target.classList.contains('qty')) {
                recalc();
            }

            if (e.target.id === 'tax' || e.target.id === 'shipping') {
                recalc();
            }
        });

        document.getElementById('addRow').addEventListener('click', function() {
            let table = document.querySelector('#itemsTable tbody');
            let firstRow = table.querySelector('tr');
            let newRow = firstRow.cloneNode(true);

            newRow.querySelectorAll('input, select').forEach(el => {
                if (el.name) {
                    el.name = el.name.replace(/\[\d+\]/, '[' + rowIndex + ']');
                }
                el.value = '';
            });

            newRow.querySelector('.qty').value = 1;

            table.appendChild(newRow);
            rowIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeRow')) {
                let rows = document.querySelectorAll('#itemsTable tbody tr');
                if (rows.length > 1) {
                    e.target.closest('tr').remove();
                    recalc();
                }
            }
        });
    </script>

    <script>
        document.getElementById('customerSelect').addEventListener('change', function() {
            let customerId = this.value;
            let addressSelect = document.getElementById('addressSelect');

            addressSelect.innerHTML = '<option value="">Loading...</option>';

            if (!customerId) {
                addressSelect.innerHTML = '<option value="">Select Address</option>';
                return;
            }

            fetch(`/admin/get/customer/address/${customerId}`)
                .then(res => res.json())
                .then(data => {
                    addressSelect.innerHTML = '<option value="">Select Address</option>';
                    data.forEach(address => {
                        addressSelect.innerHTML += `
                    <option value="${address.id}">
                        ${address.address_line1}, ${address.city}, ${address.state}
                    </option>
                `;
                    });
                });
        });
    </script>
@endpush
