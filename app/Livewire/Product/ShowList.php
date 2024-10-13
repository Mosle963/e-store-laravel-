<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Livewire Component to show a list of products with pagination.
 *
 * Functions:
 * - deleteProduct($id): void - Deletes a product by its ID.
 * - render(): \Illuminate\View\View - Renders the view with the list of products, applying pagination.
 */
class ShowList extends Component
{
    /**
     * Use Bootstrap for pagination theme.
     *
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    use WithPagination;

    /**
     * Headers for the product table.
     *
     * @var array
     */
    public $table_headers = [
        '#',
        'Product Name',
        'Supplier Id',
        'Supplier Name',
        'Unit Price',
    ];

    /**
     * Deletes a product by ID.
     *
     * @param  int  $id
     */
    public function deleteProduct($id): void
    {
        Product::find($id)->delete();
    }

    /**
     * Renders the Livewire component view.
     */
    public function render(): \Illuminate\View\View
    {
        return view('livewire.product.show-list')
            ->with('products', Product::with('supplier')->orderBy('id', 'desc')->paginate(15))
            ->layout('layouts.app')
            ->title('Products');
    }
}
