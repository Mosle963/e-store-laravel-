
<nav class="navbar navbar-expand-lg navbar-dark bg-primary ms-5">
    <a class="navbar-brand" href="{{ url('/') }}">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="navbar-brand" href="{{ route('supplier_list') }}">Suppliers</a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand" href="{{ route('customer_list') }}">Customers</a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand" href="{{ route('product_list') }}">Products</a>
            </li>
            <li class="nav-item">
                <a class="navbar-brand" href="{{ route('order_list') }}">Orders</a>
            </li>
        </ul>
    </div>
</nav>