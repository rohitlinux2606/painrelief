@extends('admin.layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet">
    <style>
        .product-img {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #eee;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .bg-active {
            background-color: #71dd37;
        }

        .bg-draft {
            background-color: #8592a3;
        }

        .bg-archived {
            background-color: #ff3e1d;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Catalog /</span> Products</h4>
            <div>
                <a href="{{ route('admin.product-control.product.create') }}" class="btn btn-primary shadow-sm">
                    <i class='bx bx-plus-circle me-1'></i> Add Product
                </a>
                <button id="bulk_delete_btn" class="btn btn-danger shadow-sm" style="display:none;">
                    <i class="bx bx-trash me-1"></i> Delete Selected (<span id="selected_count">0</span>)
                </button>
            </div>
        </div>

        {{-- FILTERS --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                @include('admin.layouts.messages')
                <form action="{{ route('admin.product-control.product.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Search Product</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Title, SKU, Brand...">
                        </div>
                        {{-- <div class="col-md-3">
                            <label class="form-label small fw-bold">Category</label>
                            <select name="category_id" class="form-select select2">
                                <option value="">All Categories</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary w-100"><i class='bx bx-filter-alt'></i>
                                Filter</button>
                            <a href="{{ route('admin.product-control.product.index') }}"
                                class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40"><input type="checkbox" class="form-check-input" id="select_all"></th>
                            <th>Product</th>
                            <th>Status</th>
                            <th>Inventory</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr id="row_{{ $product->id }}">
                                <td><input type="checkbox" class="form-check-input select_row" value="{{ $product->id }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $product->thumbnail ? asset($product->thumbnail) : 'https://placehold.co/50' }}"
                                            class="product-img me-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ $product->title }}</span>
                                            <small class="text-muted">SKU: {{ $product->sku ?? 'No SKU' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-label-{{ $product->status == 'active' ? 'success' : 'secondary' }} text-capitalize">
                                        <span class="status-dot bg-{{ $product->status }}"></span> {{ $product->status }}
                                    </span>
                                </td>
                                <td>
                                    @if ($product->track_quantity)
                                        <span class="{{ $product->stock_quantity <= 5 ? 'text-danger fw-bold' : '' }}">
                                            {{ $product->stock_quantity }} in stock
                                        </span>
                                    @else
                                        <span class="text-muted">Not tracked</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold">₹{{ number_format($product->price, 2) }}</span>
                                    @if ($product->compare_at_price)
                                        <del
                                            class="text-muted small ms-1">₹{{ number_format($product->compare_at_price, 2) }}</del>
                                    @endif
                                </td>
                                <td><span
                                        class="badge bg-label-primary">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.product-control.product.edit', $product->id) }}"
                                            class="btn btn-sm btn-icon btn-outline-primary m-1"><i
                                                class='bx bx-edit-alt'></i></a>
                                        <form action="{{ route('admin.product-control.product.destroy', $product->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this product?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-icon btn-outline-danger m-1"><i
                                                    class='bx bx-trash'></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent border-top">{{ $products->links() }}</div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Bulk Delete Logic (Same as your example)
            $('#select_all').on('click', function() {
                $('.select_row').prop('checked', $(this).prop('checked'));
                toggleBulkBtn();
            });

            $(document).on('click', '.select_row', function() {
                toggleBulkBtn();
            });

            function toggleBulkBtn() {
                let count = $('.select_row:checked').length;
                $('#selected_count').text(count);
                count > 0 ? $('#bulk_delete_btn').fadeIn() : $('#bulk_delete_btn').fadeOut();
            }
        });
    </script>
@endpush
