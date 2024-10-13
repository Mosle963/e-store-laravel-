<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;

/**
 * Livewire Component to create or edit a product.
 *
 * Functions:
 * - mount($id = 'null'): void - Initializes the component, loads product details if in edit mode, and loads suppliers.
 * - cancel(): \Livewire\Redirector - Redirects to the product list.
 * - save(): \Livewire\Redirector - Validates and saves the product details, then redirects to the product list.
 * - render(): \Illuminate\View\View - Renders the view with the appropriate title based on the mode.
 */
class CreateNew extends Component
{
    /** @var string Product name */
    public $product_name = '';

    /** @var string Supplier ID */
    public $supplier_id = '';

    /** @var string Unit price */
    public $unit_price = '';

    /** @var \Illuminate\Database\Eloquent\Collection List of suppliers to choose from */
    public $suppliers;

    /** @var bool Edit mode flag */
    public $edit_mode = false;

    /** @var int|null Product ID for editing */
    public $id = null;

    /**
     * Mounts the component on the template.
     *
     * @param  int|null  $id
     */
    public function mount($id = null): void
    {
        //if an id is passed then we are in edit mode hence view old data
        if ($id != null) {
            $product = Product::find($id);
            $this->product_name = $product->product_name;
            $this->supplier_id = $product->supplier_id;
            $this->unit_price = $product->unit_price;
            $this->edit_mode = true;
            $this->id = $id;
        }
        $this->suppliers = Supplier::all();
    }

    /**
     * Redirects to the product list.
     *
     * @return \Livewire\Redirector
     */
    public function cancel()
    {
        return redirect()->route('product_list');
    }

    /**
     * Validates and saves the product details.
     *
     * @return \Livewire\Redirector
     */
    public function save()
    {
        $validated = $this->validate([
            'product_name' => 'required|min:2|max:50',
            'supplier_id' => 'required|numeric',
            'unit_price' => 'required|numeric|min:1|max:2000000000',
        ], [
            'product_name.required' => 'The product name field is required.',
            'product_name.min' => 'The product name must be at least 2 characters.',
            'supplier_id.required' => 'A Company name is required.',
            'supplier_id.numeric' => 'A Company name is required.',
            'unit_price.required' => 'The unit price field is required.',
            'unit_price.min' => 'The unit price must be positive number greater than 1.',
            'unit_price.max' => 'The unit price must be not greater than 2B (2,000,000,000).',
        ]);

        if ($this->edit_mode) {
            Product::find($this->id)->update($validated);
        } else {
            Product::create($validated);
        }

        return redirect()->route('product_list');
    }

    /**
     * Renders the Livewire component view.
     */
    public function render(): \Illuminate\View\View
    {
        $title = $this->edit_mode ? 'edit product' : 'add new product';

        return view('livewire.product.create-new')
            ->layout('layouts.app')
            ->title($title);
    }
}
