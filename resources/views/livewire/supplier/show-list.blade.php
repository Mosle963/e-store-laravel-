<x-slot:h1>Suppliers</x-slot>
  <div>
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
          @foreach($suppliers as $supplier)
          <tr>
            <th scope="row">{{$supplier->id}}</th>
            <td>{{$supplier->company_name}}</td>
            <td>{{$supplier->contact_name}}</td>
            <td>{{$supplier->city}}</td>
            <td>{{$supplier->country}}</td>
            <td>{{$supplier->phone}}</td>
            <td>{{$supplier->fax}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{$suppliers->links()}}
  </div>