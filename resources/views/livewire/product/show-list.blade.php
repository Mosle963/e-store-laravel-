<x-slot:h1>Products</x-slot>
  <div>
    <div class="table-responsive">
      <table class="table table-striped table-hover text-center align-middle">
        <thead>
          <tr>
            @foreach($table_headers as $header)
            <th scope="col">{{$header}}</th>
            @endforeach
            <th class="text-start">
              <a type="Buttton" class="btn btn-success" href="{{ route('product_create') }}">
                Add New Product
              </a>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
          <tr>
            <th scope="row">{{$product->id}}</th>
            <td>{{$product->product_name}}</td>
            <td>{{$product->supplier->id}}</td>
            <td>{{$product->supplier->company_name}}</td>
            <td>{{$product->unit_price}}</td>
            <td class="text-start">
              <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <a type="button" class="btn btn-primary btn-sm" href="{{ route('product_edit', $product->id) }}">
                  Edit
                </a>
                <button class="btn btn-danger btn-sm" wire:click='deleteProduct({{ $product->id }})'>
                  Delete
                </button>
              </div>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{$products->links()}}
  </div>