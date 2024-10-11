<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use App\Models\Supplier;

class CreateNew extends Component
{

    public $product_name = '';
    public $supplier_id = '';
    public $unit_price = '';
    public $suppliers ;
    public $edit_mode = False;
    public $id = null;
    public function mount($id = 'null'){
        if($id != 'null'){
            $this->product_name = Product::find($id)->product_name;
            $this->supplier_id = Product::find($id)->supplier_id;
            $this->unit_price = Product::find($id)->unit_price;
            $this->edit_mode = True;
            $this->id = $id;
        }

        $this->suppliers = Supplier::all();

    }

    public function save()
    {
        $validated = $this->validate([
            'product_name' => 'required|min:2|max:50',
            'supplier_id' => 'required|numeric',
            'unit_price' => 'required|numeric|min:1|max:2000000000',
        ],
        [
            'product_name.required' => 'The product name field is required.',
            'product_name.min' => 'The product name must be at least 2 characters.',
            'supplier_id.required' => 'A Company name is required.',
            'supplier_id.numeric' => 'A Company name is required.',
            'unit_price.required' => 'The unit price field is required.',
            'unit_price.min' => 'The unit price must be positive number greater than 1.',
            'unit_price.max' => 'The unit price must be not greater than 2B (2,000,000,000).',

        ]

        );

        if($this->edit_mode)
        {
            Product::find($this->id)->update($validated);
        }
        else{
        Product::create($validated);
        }
        return redirect()->route('product_list');
    }



    public function render()
    {
        return view('livewire.product.create-new')
        ->layout('layouts.app')
        ->title('add new product');
    }
}
