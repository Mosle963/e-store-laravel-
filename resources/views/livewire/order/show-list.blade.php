<x-slot:h1>Orders</x-slot>
<div>
  <div class="table-responsive">
    <table class="table table-striped table-hover text-center align-middle">
      <thead>
        <tr>
          @foreach($table_headers as $header)
            <th scope="col">{{$header}}</th>
          @endforeach
          <th class="text-start">
            <a type="Buttton"
              class="btn btn-success"
              href="{{ route('order_create') }}"
              >
              Add New Order
            </a>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
          <tr>
            <th scope="row">{{$order->id}}</th>
            <td>{{$order->order_date}}</td>
            <td>{{$order->order_number}}</td>
            <td>{{$order->customer->id}}</td>
            <td>{{$order->customer->first_name.' '.$order->customer->last_name}}</td>
            <td>{{$order->total_amount}}</td>
            <td class="text-start">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
            <a type="button" class="btn btn-primary btn-sm"
            href="{{ route('order_edit', $order->id) }}">
            Edit
            </a>
            <button class="btn btn-danger btn-sm"
            wire:click='deleteOrder({{ $order->id }})'>
              Delete
            </button>
            </div>

            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{$orders->links()}}
</div>