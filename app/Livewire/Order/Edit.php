<?php

namespace App\Livewire\Order;

use App\Facades\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use Livewire\Component;

/**
 * Livewire Component to edit an existing order.
 *
 * Functions:
 * - mount($id = null): void - Initializes the component, clears the session, loads order details, products, and customers, and updates the cart.
 * - cancel(): \Livewire\Redirector - Clears the cart and redirects to the order list.
 * - save(): \Livewire\Redirector - Validates and saves the updated order and its items, clears the cart, and redirects to the order list.
 * - render(): \Illuminate\View\View - Renders the view with the cart content and total, and sets the page layout and title.
 * - addToCart(): void - Validates and adds a product to the cart, then updates the cart.
 * - remove_from_cart(string $id): void - Marks an item for deletion and removes it from the cart, then updates the cart.
 * - clear_cart(): void - Clears all items from the cart and re-adds old items, then updates the cart.
 * - clearSession(): void - Delete the current session key.
 * - update_cart_item(string $id, string $action): void - Updates a specified cart item based on an action (plus or minus) and updates the cart.
 * - update_cart(): void - Updates the cart content and total price for rendering.
 * - addOldItems($id): array - Adds existing order items from DB to the cart and returns their product IDs.
 */
class Edit extends Component
{
    /** @var \Illuminate\Support\Collection Items to be deleted from the order */
    public $todelete;

    /** @var array Product IDs of old items in the order */
    public $old_items_product_ids;

    /** @var int|null ID of the order being edited */
    public $order_id = null;

    /** @var int Customer ID */
    public int $customer_id;

    /** @var string Order Date */
    public string $order_date;

    /** @var \Illuminate\Database\Eloquent\Collection List of available products to choose from */
    public $products;

    /** @var int Total price of the order */
    public int $total;

    /** @var \Illuminate\Support\Collection Content of the cart */
    public $content;

    /** @var \Illuminate\Database\Eloquent\Collection List of customers to choose from */
    public $customers;

    /** @var int|null Selected product ID (Product being added to cart) */
    public ?int $product_id = null;

    /** @var int Quantity of the selected product (Product being added to cart). The default and minimum value is set to 1 */
    public int $quantity = 1;

    /**
     * Adds existing order items to the cart.
     */
    private function addOldItems(int $id): array
    {
        $passed_order = Order::with('order_items')->find($id);
        $old_items_product_ids = [];
        $old_items = $passed_order->order_items;

        foreach ($old_items as $item) {
            $old_items_product_ids[] = $item->product_id;
            Cart::add($item->product_id, $item->product_name, $item->unit_price, $item->quantity);
        }

        $ret = array_flip($old_items_product_ids);

        return $ret;
    }

    /**
     * Mounts the component on the template.
     *
     * @param  int|null  $id
     */
    public function mount($id = null): void
    {
        $this->clearSession();
        $passed_order = Order::with('order_items')->find($id);
        $this->customer_id = $passed_order->customer_id;
        $this->order_date = $passed_order->order_date;
        $this->products = Product::all();
        $this->customers = Customer::all();
        $this->todelete = collect([]);
        $this->order_id = $id;
        $this->update_cart();
        $this->old_items_product_ids = $this->addOldItems($id);
        $this->update_cart();
    }

    /**
     * Abort editing the order and redirects to the order list.
     */
    public function cancel()
    {
        Cart::clear();

        return redirect()->route('order_list');
    }

    /**
     * Saves the updated order and order items to the database.
     */
    public function save()
    {
        $this->update_cart();
        $validated = $this->validate([
            'customer_id' => 'required|numeric',
            'order_date' => 'required',
        ], [
            'customer_id.required' => 'A customer name is required.',
            'customer_id.numeric' => 'A customer name is required.',
            'order_date.required' => 'The Order Date field is required.',
        ]);

        $passed_order = Order::find($this->order_id);
        $passed_order->update($validated);

        foreach ($this->content as $key => $value) {

            //if a product is deleted then added we should remove it from to delete list
            if ($this->todelete->has($key)) {
                $this->todelete->forget($key);
            }

            //if a product already is an order_item in the DB we should update the recodrd and not add new one
            if (isset($this->old_items_product_ids[$key])) {
                $order_item = Order_item::where('order_id', $this->order_id)
                    ->where('product_id', $key)
                    ->first();
                $order_item->update([
                    'product_id' => intval($key),
                    'product_name' => $value['name'],
                    'order_id' => $passed_order->id,
                    'unit_price' => intval($value['price']),
                    'quantity' => intval($value['quantity']),
                ]);
            } else {
                Order_item::create([
                    'product_id' => intval($key),
                    'product_name' => $value['name'],
                    'order_id' => $passed_order->id,
                    'unit_price' => intval($value['price']),
                    'quantity' => intval($value['quantity']),
                ]);
            }
        }

        //every product still in the to delete list may have an order_item record in DB should be deleted
        foreach ($this->todelete as $key => $value) {
            $order_item = Order_item::where('order_id', $this->order_id)
                ->where('product_id', $key)
                ->first();
            if ($order_item != null) {
                $order_item->delete();
            }
        }

        Cart::clear();

        return redirect()->route('order_list');
    }

    /**
     * Renders the Livewire component view.
     */
    public function render(): \Illuminate\View\View
    {
        return view('livewire.order.create-new', [
            'total' => $this->total,
            'content' => $this->content,
        ])->layout('layouts.app')
            ->title('Edit Order');
    }

    /**
     * Adds an item to the cart.
     *
     * @param  int  $id
     * @param  int  $quantity
     */
    public function addToCart(): void
    {
        $validated = $this->validate([
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1|max:2000',
        ], [
            'product_id.required' => 'A product name is required.',
            'product_id.numeric' => 'A product name is required.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.min' => 'The quantity must be at least one.',
            'quantity.max' => 'The quantity must be not greater than 2000.',
        ]);

        // Getting the record of the chosen product to access info
        $product = Product::find($validated['product_id']);
        Cart::add($product->id, $product->product_name, $product->unit_price, $validated['quantity']);
        $this->update_cart();
        $this->product_id = null;
        $this->quantity = 1;
    }

    /**
     * Removes a cart item by id.
     */
    public function remove_from_cart(string $id): void
    {
        //maintain a list of all delted products in case some have record in db so we van delete them on save
        if (! $this->todelete->has($id)) {
            $this->todelete->put($id, 'true');
        }
        Cart::remove($id);
        $this->update_cart();
    }

    /**
     * Clears the cart content.
     */
    public function clear_cart(): void
    {
        Cart::clear();
        //start with a fresh to delete list after clearing
        $this->todelete = collect([]);
        //the cleared cart still has old items sice we are in edit mode
        $this->addOldItems($this->order_id);
        $this->update_cart();
    }

    /**
     * Clears the session.
     */
    public function clearSession(): void
    {
        Cart::clear();
    }

    /**
     * Updates a cart item.
     */
    public function update_cart_item(string $id, string $action): void
    {
        Cart::update($id, $action);
        $this->update_cart();
    }

    /**
     * Updates the public vars to be rendered to the web page with correct values.
     */
    public function update_cart(): void
    {
        $this->total = Cart::total();
        $this->content = Cart::content();
    }
}
