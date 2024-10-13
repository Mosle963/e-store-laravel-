<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom w-100">
    <!-- Added w-100 here -->
    <div class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap" />
        </svg>
        <span class="fs-4">{{ $h1 ?? 'E-store' }}</span>
    </div>
    <ul class="nav nav-pills me-3">
        <li class="nav-item"><a href="{{ url('/') }}" class="nav-link" aria-current="page">Home</a></li>
        <li class="nav-item"><a href="{{ route('supplier_list') }}" class="nav-link">Suppliers</a></li>
        <li class="nav-item"><a href="{{ route('customer_list') }}" class="nav-link">Customers</a></li>
        <li class="nav-item"><a href="{{ route('product_list') }}" class="nav-link">Products</a></li>
        <li class="nav-item"><a href="{{ route('order_list') }}" class="nav-link">Orders</a></li>
    </ul>
</header>