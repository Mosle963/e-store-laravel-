<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class ShowList extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $table_headers = [
        '#',
        'Product Name',
        'Supplier Id',
        'Supplier Name',
        'Unit Price',
    ];
    public function deleteProduct($id)
    {
        Product::find($id)->delete();
    }
    public function render()
    {
        return view('livewire.product.show-list')
        ->with('products' , Product::with('supplier')->orderBy('id', 'desc')->paginate(15))
        ->layout('layouts.app')
        ->title('Products');
    }
}
