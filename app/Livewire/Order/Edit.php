<?php


namespace App\Livewire\Order;

use Livewire\Component;
use Carbon\Carbon;
use App\Facades\Cart;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order_item;
use App\Models\Order;

class Edit extends Component
{
    public $todelete ;
    public $old_items_product_ids ;
    public $order_id = null;

    public $customer_id;
    public $order_date;
    public $products;
    public $total;
    public $content=[];
    public $customers;
    public $product_id = null;
    public $quantity = 1;
    public $session_name;



    private function add_old_items($id)
    {
        $passed_order = Order::with('order_items')->find($id);
        $old_items_product_ids = [];
        $old_items = $passed_order->order_items;
        foreach ($old_items as $item)
        {
            $old_items_product_ids[] = $item->product_id;
            Cart::add($item->product_id,
                    $item->product_name,
                    $item->unit_price,
                    $item->quantity,
                    $this->session_name);
        }

        $ret  = array_flip($old_items_product_ids);
        return $ret;
    }


    /**
     * Mounts the component on the template.
     *
     * @return void
     */
    public function mount($id=null)
    {
        $this->session_name = 'edit'.$id;
        $this->startsession('edit'.$id);
        $passed_order = Order::with('order_items')->find($id);
        $this->customer_id = $passed_order->customer_id;
        $this->order_date = $passed_order->order_date;
        $this->products = Product::all();
        $this->customers = Customer::all();
        $this->todelete = collect([]);
        $this->order_id = $id;

        $this->updateCart();
        $this->old_items_product_ids = $this->add_old_items($id);
        $this->updateCart();

    }


    public function closeOrder()
    {
        Cart::clear($this->session_name);
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

        $passed_order = Order::find($this->order_id);
        $passed_order->update($validated);

        foreach($this->content as $key=>$value){
            if($this->todelete->has($key))
                $this->todelete->forget($key);

            if(isset($this->old_items_product_ids[$key]))
            {
                $order_item = Order_item::where('order_id', $this->order_id)
                            ->where('product_id', $key)
                            ->first();
                $order_item->update([
                        'product_id'=>intval($key),
                        'product_name'=>$value['name'],
                        'order_id'=>$passed_order->id,
                        'unit_price'=>intval($value['price']),
                        'quantity'=>intval($value['quantity'])
                    ]
                );
            }
            else
            {
                Order_item::create([
                'product_id'=>intval($key),
                'product_name'=>$value['name'],
                'order_id'=>$passed_order->id,
                'unit_price'=>intval($value['price']),
                'quantity'=>intval($value['quantity'])
                ]);
            }
        }

        foreach($this->todelete as $Key=>$value)
        {
            $order_item = Order_item::where('order_id', $this->order_id)
            ->where('product_id', $key)
            ->first();

            if($order_item != null)
                {$order_item->delete();}
        }
        Cart::clear($this->session_name);
        return redirect()->route('order_list');
    }
    public function render()
    {
        return view('livewire.order.create-new',[
            'total' => $this->total,
            'content' => $this->content,
        ])->layout('layouts.app')
        ->title('Edit Order');
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
        Cart::add($product->id, $product->product_name, $product->unit_price, $validated['quantity'],$this->session_name);
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
        if(! $this->todelete->has($id))
            $this->todelete->put($id,'true');

        Cart::remove($id,$this->session_name);
        $this->updateCart();
    }

    /**
     * Clears the cart content.
     *
     * @return void
     */
    public function clearCart(): void
    {
        Cart::clear($this->session_name);
        $this->add_old_items($this->order_id);
        $this->updateCart();
    }

    public function startsession($session_name): void
    {
        Cart::clear($session_name);
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
        Cart::update($id, $action,$this->session_name);
        $this->updateCart();
    }
    /**
     * Rerenders the cart items and total price on the browser.
     *
     * @return void
     */
    public function updateCart()
    {
        $this->total = Cart::total($this->session_name);
        $this->content = Cart::content($this->session_name);
    }
}
