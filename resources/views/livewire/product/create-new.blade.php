<x-slot:h1>Add Product</x-slot>

<div>
<form wire:submit="save">
  <div class="mb-3">
    <label for="product_name" class="form-label">Product Name</label>
    <input class="form-control @error('product_name') is-invalid @enderror" id="product_name" wire:model="product_name">
    <div class="invalid-feedback">@error('product_name') {{ $message }} @enderror</div>
  </div>
  <div class="mb-3">
    <label for="supplier_id" class="form-label">Company Name</label>
    <select class="form-select @error('supplier_id') is-invalid @enderror" id="supplier_id" wire:model="supplier_id">
      <option selected value='select'>Select...</option>
      @foreach($suppliers as $supplier)
        <option value='{{$supplier->id}}'>{{$supplier->company_name}}</option>
      @endforeach
    </select>
    <div class="invalid-feedback">@error('supplier_id') {{ $message }} @enderror</div>
  </div>
  <div class="mb-3">
    <label for="unit_price" class="form-label">Unit Price</label>
    <input type="number" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price" wire:model="unit_price">
    <div class="invalid-feedback">@error('unit_price') {{ $message }} @enderror</div>
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
</form>
</div>

