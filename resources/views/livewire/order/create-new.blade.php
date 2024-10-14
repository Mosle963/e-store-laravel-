<x-slot:h1>
    @if($edit_mode)
    Edit Order
    @else
    Create Order
    @endif
    </x-slot>
    <x-slot:extra_style>
        <link href="{{ asset('css/order-create-new.css') }}" rel="stylesheet">
        </x-slot>

        <div>
            <form id="create-order-form">
                <div class="container-card">
                    <div class="row">
                        <!-- Customer Name -->
                        <div class="col-md-6">
                            <label for="customer_id" class="form-label">Customer Name:</label>
                            <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id"
                                wire:model="customer_id">
                                <option selected value='select'>Select...</option>
                                @foreach($customers as $customer)
                                <option value='{{$customer->id}}'>{{$customer->first_name . ' ' . $customer->last_name}}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @error('customer_id') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Order Date -->
                        <div class="col-md-6 ">
                            <label for="order_date" class="form-label">Order Date:</label>
                            <input class="form-control @error('order_date') is-invalid @enderror" id="order_date"
                                wire:model="order_date" type="date">
                            <div class="invalid-feedback">
                                @error('order_date') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Add product to cart -->
            <div class="container-card">
                <form wire:submit="addToCart">
                    <div class="even-distribution">
                        <!-- Product Name -->
                        <div>
                            <label for="product_id" class="form-label">Product Name:</label>
                        </div>
                        <div>
                            <select class="form-select @error('product_id') is-invalid @enderror" id="product_id"
                                wire:model="product_id">
                                <option selected>Select...</option>
                                @foreach($products as $product)
                                <option value='{{$product->id}}'>{{$product->product_name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback ms-5">
                                @error('product_id') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="quantity" class="form-label">Quantity:</label>
                        </div>
                        <div>
                            <input class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                wire:model="quantity" type="number" min="1" max="2000">
                            <div class="invalid-feedback ms-5">
                                @error('quantity') {{ $message }} @enderror
                            </div>
                        </div>

                        <!-- Add to Order Button -->
                        <div>
                            <button class="btn btn-primary" type="submit">Add to order</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Items Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($content as $key => $value)
                        <tr>
                            <td>{{$value['name']}}</td>
                            <td>{{$value['price']}}</td>
                            <td>{{$value['quantity']}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <button class="btn btn-success" wire:click="update_cart_item({{$key}},'minus')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                            fill="currentColor" class="bi bi-arrow-down-circle" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                                        </svg>
                                    </button>


                                    <button class="btn btn-warning"
                                        wire:click="remove_from_cart({{$key}})">Remove</button>
                                    <button class="btn btn-success" wire:click="update_cart_item({{$key}},'plus')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                            fill="currentColor" class="bi bi-arrow-up-circle" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Total:</strong></td>
                            <td><strong>{{ $total }}</strong></td>
                            <td colspan="1"></td>
                            <td><button wire:click="clear_cart" class="btn btn-info">Reset</bytton>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="button-group">
                <button class="btn btn-primary btn-lg" wire:click="save">Save</button>
                <button class="btn btn-secondary btn-lg" wire:click="cancel">Cancel</button>
            </div>
        </div>