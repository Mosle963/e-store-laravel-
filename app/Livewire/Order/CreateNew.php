<?php

namespace App\Livewire\Order;

use Livewire\Component;
use Carbon\Carbon;
use App\Facades\Cart;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order_item;
use App\Models\Order;
class CreateNew extends Component
{
    public $customer_id;
    public $order_date;
    public $products;
    protected $total;
    protected $content=[];
    public $customers;
    public $product_id = null;
    public $quantity = 1;

    /**
     * Mounts the component on the template.
     *
     * @return void
     */
    public function mount()
    {
        $this->products = Product::all();
        $this->customers = Customer::all();
        $this->updateCart();
    }
    public function closeOrder()
    {
        Cart::clear();
        return redirect()->route('order_list');
    }
    public function save()
    {
        $this->updateCart();

        $validated = $this->validate([
            'customer_id' => 'required|numeric',
            'order_date' => 'required',
        ],
        [
            'customer_id.required' => 'A customer name is required.',
            'customer_id.numeric' => 'A customer name is required.',
            'order_date.required' => 'The Order Date field is required.',
        ]
        );
        $new_order = Order::create($validated);
        foreach($this->content as $key=>$value){
            Order_item::create([
                'product_id'=>intval($key),
                'product_name'=>$value['name'],
                'order_id'=>$new_order->id,
                'unit_price'=>intval($value['price']),
                'quantity'=>intval($value['quantity'])
            ]);
        }
        Cart::clear();
        return redirect()->route('order_list');
    }
    public function render()
    {
        return view('livewire.order.create-new',[
            'total' => $this->total,
            'content' => $this->content,
        ])->layout('layouts.app')
        ->title('Create Order');
    }

    /**
     * Adds an item to cart.
     * @param int $id
     * @param int $quantity
     * @return void
     */
    public function addToCart()
    {
        $validated = $this->validate([
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1|max:2000',
        ],
        [
            'product_id.required' => 'A product name is required.',
            'product_id.numeric' => 'A product name is required.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.min' => 'The quantity must be at least one.',
            'quantity.max' => 'The quantity must be not greater than 2000.',

        ]
        );

        $product = Product::find($validated['product_id']);
        Cart::add($product->id, $product->product_name, $product->unit_price, $validated['quantity']);
        $this->updateCart();
        $this->product_id = null;
        $this->quantity =1;
    }

    /**
     * Removes a cart item by id.
     *
     * @param string $id
     * @return void
     */
    public function removeFromCart(string $id): void
    {
        Cart::remove($id);
        $this->updateCart();
    }

    /**
     * Clears the cart content.
     *
     * @return void
     */
    public function clearCart(): void
    {
        Cart::clear();
        $this->updateCart();
    }

    /**
     * Updates a cart item.
     *
     * @param string $id
     * @param string $action
     * @return void
     */
    public function updateCartItem(string $id, string $action): void
    {
        Cart::update($id, $action);
        $this->updateCart();
    }
    /**
     * Rerenders the cart items and total price on the browser.
     *
     * @return void
     */
    public function updateCart()
    {
        $this->total = Cart::total();
        $this->content = Cart::content();
    }
}