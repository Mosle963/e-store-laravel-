<x-slot:h1>Customers</x-slot>
<div class="table-responsive">
  <table class="table table-striped table-hover text-center">
    <thead>
        <tr>
          @foreach($table_headers as $header)
            <th scope="col">{{$header}}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach($customers as $customer)
          <tr>
            <th scope="row">{{$customer->id}}</th>
            <td>{{$customer->first_name}}</td>
            <td>{{$customer->last_name}}</td>
            <td>{{$customer->city}}</td>
            <td>{{$customer->country}}</td>
            <td>{{$customer->phone}}</td>
          </tr>
        @endforeach
    </tbody>
  </table>
  {{ $customers->links() }}
  </div>